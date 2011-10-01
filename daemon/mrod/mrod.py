#!/usr/bin/python
'''
 NAME: mrod.py
 DESC: MapRenderOnDemand - takes a json description of a map to be rendered,
       Constructs the carto layer specification from it, then uses
       carto to create a mapnik style sheet.
       It assumes that the style files, symbols and world_boundaries
       directories are in the current working directory.
       The map is then rendered using mapnik to create an image.
'''
import os,sys
from optparse import OptionParser
import json
import mapnik2 as mapnik
from createGridShapefile import createGridShapefile
from paperSize import getPaperSize
from createMml import createMml
import srtm
import ll2os


options=[]
xmlmapfile = "osm_carto.xml"
map_uri = "image.png"



##########################################################################
def getProjStr(projection):
    '''
    Returns the appropriate proj4 projection devinition string given the
    shortcut name 'projection'.
    Valid values for projection are 'merc' for the google spherical mercator 
    projection, or 'osgb' for the GB Ordnance survey projection.
    '''
    projStrs = {
        "merc":"+proj=merc +a=6378137 +b=6378137 +lat_ts=0.0 +lon_0=0.0 +x_0=0.0 +y_0=0 +k=1.0 +units=m +nadgrids=@null +no_defs",
        "osgb":"+proj=tmerc +lat_0=49 +lon_0=-2 +k=0.999601 +x_0=400000 +y_0=-100000 +ellps=airy +units=m +datum=OSGB36 +no_defs no_defs"
        }
    if projection in projStrs:
        return projStrs[projection]
    else:
        print "projection %s is not valid - defaulting to 'merc'." % projection
        return projStrs['merc']

def downloadOSMData(ll):
    """ Downloads OSM data for the specified bounding box and
    uploads it into the postgresql database.
    """
    # XAPI Server
    print 'Using OSM XAPI Server for data download'
    url="http://jxapi.openstreetmap.org/xapi/api/0.6/map?bbox=%f,%f,%f,%f" %\
                 (ll[0],ll[1],ll[2],ll[3])
    osmFile = "townguide.osm"
    print "url="+url
    os.system("wget %s -O %s" % (url,osmFile))

    if os.path.exists(osmFile):
        try:
            print 'Importing data into postgresql database....'
            osm2pgsqlStr = "osm2pgsql -m -s -S %s/%s -d %s -a %s" %\
                (".",
                 "default.style",
                 "mapnik",
                 osmFile)
            print "Calling osm2pgsql with: %s" % osm2pgsqlStr
            retval = os.system(osm2pgsqlStr)
            if (retval==0):
                print 'Data import complete.'
            else:
                print 'osm2pgsql returned %d - exiting' % retval
            # system.exit(-1)
        except:
            print "Exception Occurred running osm2pgsql"
            system.exit(-1)
    else:
        print "ERROR:  Failed to download OSM data"
        print "Aborting...."
        system.exit(-1)



def downloadSRTMData(ll):
    """ Downloads SRTM data, converts it to contours, and uploads
    it into a postgresql database.
    26sep2011 GJ  ORIGINAL VERSION
    """
    srtmTmpDir = "srtm_tmp"
    mergeHgt = "srtm.hgt"
    mergeTif = "srtm.tiff"
    contoursShp = "contours.shp"
    hillshadeTif = "hillshade.tiff"

    # First clean out the temporary directory
    oldFileList = os.listdir(srtmTmpDir)
    for fname in oldFileList:
        print "removing %s/%s" % (srtmTmpDir,fname)
        os.remove("%s/%s" % (srtmTmpDir,fname))
    print "removing directory ",srtmTmpDir
    os.rmdir(srtmTmpDir)


    print "downloadSRTMData()"
    downloader = srtm.SRTMDownloader()
    downloader.loadFileList()
    print "ll=",ll
    tileSet = downloader.getTileSet(ll)
    print tileSet

    os.makedirs(srtmTmpDir)
    origWd = os.getcwd()
    os.chdir(srtmTmpDir)
    for tileFname in tileSet:
        fnameParts = tileFname.split("/")
        fname = fnameParts[-1]
        os.symlink("../%s" % (tileFname),
                   "%s" % (fname))
        os.system("unzip %s" % (fname))
        os.remove(fname)

    # Now merge the individual srtm tiles into a single big one.
    mergeCmd = "gdal_merge.py -o %s " % mergeHgt
    fileList = os.listdir(".")
    for fname in fileList:
        mergeCmd = "%s %s" % (mergeCmd,fname)
    print mergeCmd
    os.system(mergeCmd)

    print "Generating Contour Lines...."
    os.system("gdal_contour -i 10 -snodata 32767 -a height %s %s" %
              (mergeHgt,contoursShp))

    print "Generating Hillshading overlay image...."
    print "      re-projecting SRTM data to map projection..."
    os.system("gdalwarp -of GTiff -co \"TILED=YES\" -srcnodata 32767 -t_srs \"+proj=merc +ellps=sphere +R=6378137 +a=6378137 +units=m\" -rcs -order 3 -tr 30 30 -multi %s %s" % (mergeHgt,mergeTif))
    print "      generating hillshade image...."
    os.system("hillshade  %s %s -z 2" % (mergeTif,hillshadeTif))

    os.chdir(origWd)


###########################################################################

def renderMap(mapSpecJSON,settingsJSON):
    '''
    Render a map to an image file, as specified in the JSON string mapSpecJSON.
    The following are expected in the mapSpec JSON object:
            jobID - an identifier for this particular rendering job.
            projection - 'merc' for a spherical mercator projection
                         'osgb' for Ordnance Survey GB Projection
            origin - 'lon':lon, 'lat':lat - longitude and latitude of bottom left corner of map.
            scale - the scale of the map (10000 = 1:10000).
            resolution - the required image output resolution in dpi.
            paper - specification for the size of the image 
    '''
    # mso = mapSpecObject
    mso = json.loads(mapSpecJSON)
    #seto = settings Object
    seto = json.loads(settingsJSON)
    if (options.verbose): 
        print "Imported settings as:\n%s\n" % (seto.__str__())
        print "Imported Mapspec as:\n%s\n" % (mso.__str__())
    jobID = mso['jobID']
    projection = mso['projection']
    lat = mso['origin']['lat']
    lon = mso['origin']['lon']
    scale = mso['scale']
    paper = mso['paper']['size']
    if 'resolution' in mso: 
        img_dpi = mso['resolution']
    else:
        img_dpi = 300
    print "jobID = %d." % (jobID)
    print "origin = (%f,%f)." % (lon,lat)
    print "scale = %f." % (scale)
    print "paper = %s." % (paper)

    (imgw,imgh) = getPaperSize(mso['paper'])
    print "(imgw,imgh) = (%f,%f)." % (imgw,imgh)

    projStr = getProjStr(mso['projection']);
    print "projStr = %s" % projStr

    ######################################################
    # Calculate map Bounding Box (in degrees and metres) #
    ######################################################
    prj = mapnik.Projection(projStr)
    # Convert origin (bottom left corner) to metres as c0
    c0 = prj.forward(mapnik.Coord(lon,lat))
    # calculate top right in metres given image size and map scale.
    c1 = mapnik.Coord(c0.x + scale*imgw/100.,
                      c0.y + scale*imgh/100.)
    print c0,c1

    c1_ll = prj.inverse(c1)
    ll = (lon,lat,c1_ll.x,c1_ll.y)
    print "bbox="+str(ll)

    c0 = prj.forward(mapnik.Coord(ll[0],ll[1]))
    c1 = prj.forward(mapnik.Coord(ll[2],ll[3]))
    print c0,c1



    # Get or create the layer definitions.
    # If the mapspec contains a 'baseMap' attribute, we assume
    #  that this points to a valid .mml definition file.
    # Otherwise we use the 'Layers' array from the mapspec to build
    # a .mml file ourselves.
    try:
        # the .mml is optional, so we split it of before adding it again
        # to get the full file name.
        baseMap = mso['baseMap'].split('.mml')[0] + ".mml"
        print "basemap=%s - using that for map layer definitions" % (baseMap)
    except:
        print "baseMap not defined, trying to build a layer definition file from the 'Layers' array...."
        baseMap = "mrodAuto.mml"
        layersArr = mso['Layers']
        print layersArr
        osGridSquareList = ll2os.bbox2gridList(ll)
        print osGridSquareList

        createMml(baseMap,layersArr,osGridSquareList,seto)


        #        baseMapFile = open(baseMap)
        #        baseMapJSON = baseMapFile.read()
        #        bso = json.loads(baseMapJSON)
        #        for mapobj in bso:
        #            print mapobj


    ###################
    # Data Processing #
    ###################
    downloadOsmDataFlag = True
    downloadSrtmDataFlag = True
    createGridShapefileFlag = True
    if not 'processing' in mso:
        print "no processing instructions provided - processing everything!"
    else:
        if 'downloadOsmData' in mso['processing']:
            downloadOsmDataFlag = mso['processing']['downloadOsmData']
        if 'downloadSrtmData' in mso['processing']:
            downloadSrtmDataFlag = mso['processing']['downloadSrtmData']
        if 'createGridShapefile' in mso['processing']:
            createGridShapefileFlag = mso['processing']['createGridShapefile']

    print "downloadOsmData = %d" % downloadOsmDataFlag
    print "downloadSrtmData = %d" % downloadSrtmDataFlag
    print "createGridShapefile = %d" % createGridShapefileFlag

    if createGridShapefileFlag: createGridShapefile(ll)
    if downloadSrtmDataFlag: downloadSRTMData(ll)
    if downloadOsmDataFlag: downloadOSMData(ll)

    ######################
    # Now Render the Map #
    ######################


    print "Making Mapnik2 compatible style from standard OSM stylesheets"
    os.system("rm %s" % xmlmapfile)
    cartoCmd ="carto %s > %s" % (baseMap,xmlmapfile)
    print "cartoCmd = %s\n" % cartoCmd
    os.system(cartoCmd)
    print "created %s" % xmlmapfile

    mapnik_scale_factor = img_dpi / 90.7
    imgx = int(imgw * img_dpi / 2.54)
    imgy = int(imgh * img_dpi / 2.54)

    print "generating map...."
    m = mapnik.Map(imgx,imgy)
    mapnik.load_map(m,xmlmapfile)
    bbox = mapnik.Box2d(c0.x,c0.y,c1.x,c1.y)
    m.zoom_to_box(bbox)
    im = mapnik.Image(imgx,imgy)
    mapnik.render(m, im,mapnik_scale_factor)
    view = im.view(0,0,imgx,imgy) # x,y,width,height
    view.save(map_uri,'png')

    print "done - image stored as %s" % map_uri




##########################################################################
if __name__ == "__main__":
    print "MROD - Mapnik Rendering on Demand"

    usage = "Usage %prog [options] mapspec"
    version = "0.1"
    parser = OptionParser(usage=usage,version=version)
    parser.add_option("-v", "--verbose", action="store_true",dest="verbose",
                     help="Include verbose output")
    parser.add_option("-d", "--debug", action="store_true",dest="debug",
                     help="Include debug output")
    parser.add_option("-s", "--settings",dest="settings",
                     help="Filename of settings JSON file (default is ./settings.json)")
    parser.set_defaults(
        debug=False,
        verbose=False,
        settings="./settings.json")
    (options,args)=parser.parse_args()
   
    if (options.debug):
        options.verbose = True
        print "options   = %s" % options
        print "arguments = %s" % args
   
    if len(args)==0:
        infname = "stdin"
    else:
        infname = args[0]

    if (options.verbose): print "infname = %s" % (infname)

    if (infname=="stdin"):
        if (options.verbose): print "Reading from standard input - ctrl-d to finish"
        infile = sys.stdin
    else:
        infile = open(infname)

    mapSpecJSON = infile.read()

    settingsFile = open(options.settings)
    settingsJSON = settingsFile.read()


    if (options.verbose): print "Mapspec is:\n%s\n" % mapSpecJSON
    renderMap(mapSpecJSON,settingsJSON)






