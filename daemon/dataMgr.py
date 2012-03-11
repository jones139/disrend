"""
dataMgr - manages map data ready for rendering using mapnik.
"""

import srtm
import os
import paperSize
import getProjStr
import mapnik

class dataMgr:
    def __init__(self,sysCfg):
        print "dataMgr.__init__()"
        self.sysCfg = sysCfg
        print sysCfg

    def setBbox(self,jobCfg):
        """Calculates the lat-lon bounding box, setting jobCfg['ll']
        to contain the bounding box.  Uses the map centre specified as
        jobCfg['origin']['lat'], jobCfg['origin']['lon'], the map scale
        and paper size given in jobCfg.
        """
        print "setBbox()"
        projection = jobCfg['projection']
        lat = float(jobCfg['origin']['lat'])
        lon = float(jobCfg['origin']['lon'])
        scale = float(jobCfg['mapScale'])
        paper = jobCfg['paper']['size']
        (imgw,imgh) = paperSize.getPaperSize(jobCfg['paper'])
        print "(imgw,imgh) = (%f,%f)." % (imgw,imgh)
    
        projStr = getProjStr.getProjStr(jobCfg['projection']);
        print "projStr = %s" % projStr
        
        ######################################################
        # Calculate map Bounding Box (in degrees and metres) #
        ######################################################
        prj = mapnik.Projection(projStr)
        # Convert origin (centre) to metres as c_origin
        c_origin = prj.forward(mapnik.Coord(lon,lat))
        # calculate top right in metres given image size and map scale.
        mapw = scale*imgw/100.  # width of map representation in metres.
        maph = scale*imgw/100.  # height of map representation in metres.
        # c0 = bottom left corner position in metres.
        c0 = mapnik.Coord(c_origin.x - mapw/2.0,
                          c_origin.y - maph/2.0)
        # c1 = top right corner position in metres.
        c1 = mapnik.Coord(c_origin.x + mapw/2.0,
                          c_origin.y + maph/2.0)
        print c0,c1

        c0_ll = prj.inverse(c0)
        c1_ll = prj.inverse(c1)
        ll = (c0_ll.x,c0_ll.y,c1_ll.x,c1_ll.y)
        
        jobCfg['ll'] = ll


    def getOSMData(self,jobCfg):
        print "getOSMData"

    def getSRTMData(self,jobCfg):
        """ Downloads SRTM data, converts it to contours, and uploads
        it into a postgresql database.
        26sep2011 GJ  ORIGINAL VERSION
        """
        print "getSRTMData"
        self.setBbox(jobCfg)
        srtmTmpDir = "srtm_tmp"
        mergeHgt = "srtm.hgt"
        mergeTif = "srtm.tiff"
        contoursShp = "contours.shp"
        hillshadeTif = "hillshade.tiff"

        # First clean out the temporary directory
        if os.path.isdir(srtmTmpDir):
            oldFileList = os.listdir(srtmTmpDir)
            for fname in oldFileList:
                print "removing %s/%s" % (srtmTmpDir,fname)
                os.remove("%s/%s" % (srtmTmpDir,fname))
            print "removing directory ",srtmTmpDir
            os.rmdir(srtmTmpDir)


        print "downloadSRTMData()"
        downloader = srtm.SRTMDownloader()
        downloader.loadFileList()
        ll = jobCfg['ll']
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



    def getGridData(self,jobCfg):
        print "getGridData"


    def getMapnikStyleFile(self,jobCfg):
        print "getMapnikStyleFile"
        jobCfg['mapnikStyleFile'] = self.sysCfg['osmMapnikStyleFile']

        


if __name__ == "__main__":
    print "dataMgr.py"
    sysCfg = {}
    dm = dataMgr(sysCfg)
    print "done"

