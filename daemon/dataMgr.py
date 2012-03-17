"""
dataMgr - manages map data ready for rendering using mapnik.
"""

import srtm
import createGridShapefile
import os
import paperSize
import getProjStr
import mapnik

class dataMgr:
    def __init__(self,sysCfg):
        print "dataMgr.__init__()"
        self.sysCfg = sysCfg
        print sysCfg

        self.shpExt = ["shp","prj","shx","dbf"]

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
        maph = scale*imgh/100.  # height of map representation in metres.
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

    def getSRTMData(self,sysCfg,jobCfg):
        """ Downloads SRTM data, converts it to contours, and uploads
        it into a postgresql database.
        26sep2011 GJ  ORIGINAL VERSION
        """
        print "getSRTMData"
        print jobCfg
        origWd = os.getcwd()
        self.setBbox(jobCfg)
        srtmTmpDirName = "srtm_tmp"
        mergeHgt = "srtm.hgt"
        mergeTif = "srtm.tiff"
        contoursShp = "contours.shp"
        hillshadeTif = "hillshade.tiff"

        jobDir = jobCfg['jobDir']
        srtmTmpDir = "%s" % (jobDir)

        # First clean out the temporary directory
        #if os.path.isdir(srtmTmpDir):
        #    oldFileList = os.listdir(srtmTmpDir)
        #    for fname in oldFileList:
        #        print "removing %s/%s" % (srtmTmpDir,fname)
        #        os.remove("%s/%s" % (srtmTmpDir,fname))
        #    print "removing directory ",srtmTmpDir
        #    os.rmdir(srtmTmpDir)


        downloader = srtm.SRTMDownloader(cachedir=sysCfg['srtmDir'])
        downloader.loadFileList()
        ll = jobCfg['ll']
        print "ll=",ll
        tileSet = downloader.getTileSet(ll)
        print tileSet

        if not os.path.exists(srtmTmpDir):
            os.makedirs(srtmTmpDir)
        os.chdir(srtmTmpDir)
        for tileFnameZip in tileSet:
            tileFname = tileFnameZip.split(".zip")[0]
            fnameZipParts = tileFnameZip.split("/")
            # The compressed file, without the path
            fname = fnameZipParts[-1]
            print tileFnameZip,fname
            os.chdir(sysCfg['srtmDir'])

            ######################################################
            # Get the pre-generated contours shapefile for this 
            # srtm tile if it exists.
            contourFname = "%s%s" % (tileFname,".contours.shp")
            print "contourFname=%s" % contourFname
            if not os.path.exists(contourFname):
                print "contour File does not exist - creating..."
                os.chdir(sysCfg['srtmDir'])
                print tileFnameZip,fname
                # uncompress the raw srtm file.
                if not os.path.exists(tileFname):
                    os.system("unzip %s" % (tileFnameZip))

                print "Generating Contour Lines...."
                os.system("gdal_contour -i 10 -snodata 32767 -a height %s %s" %
                          (tileFname,contourFname))
            os.chdir(srtmTmpDir)
            # create symbolic link to contours shape file.
            print "Linking contours file"
            contourFnameBase = contourFname.split(".shp")[0]
            fnameBase = contourFnameBase.split("/")[-1]
            for ext in self.shpExt:
                fname = "%s.%s" % (fnameBase,ext)
                if os.path.exists(fname):
                    os.remove(fname)
                os.symlink("%s.%s" % (contourFnameBase,ext),
                           "%s" % (fname))
            ###############################################################
            # Get the pre-generated hillshade .tiff file if it exists.
            hillshadeFname = "%s%s" % (tileFname,".hillshade.tiff")
            print "hillshadeFname=%s" % hillshadeFname
            if not os.path.exists(hillshadeFname):
                print "hillshade File does not exist - creating..."
                # uncompress the raw srtm file.
                if not os.path.exists(tileFname):
                    os.system("unzip %s" % (tileFnameZip))
                print "Generating Hillshade file...."
                print "Generating Hillshading overlay image...."
                print "      re-projecting SRTM data to map projection..."
                os.system("gdalwarp -of GTiff -co \"TILED=YES\" -srcnodata 32767 -t_srs \"+proj=merc +ellps=sphere +R=6378137 +a=6378137 +units=m\" -rcs -order 3 -tr 30 30 -multi %s %s" % (tileFname,mergeTif))
                print "      generating hillshade image...."
                os.system("hillshade  %s %s -z 2" % (mergeTif,hillshadeFname))
                # Remove the temporary reprojected geotiff.
                os.remove(mergeTif)

            os.chdir(srtmTmpDir)
            # create symbolic link hillshade tiff file.
            print "Linking hillshade file"
            fname = hillshadeFname.split("/")[-1]
            if os.path.exists(fname):
                os.remove(fname)
            os.symlink("%s" % (hillshadeFname),
                       "%s" % (fname))

            # Remove the uncompressed raw srtm tile from the cache.
            if os.path.exists(tileFname):
                print "removing uncompressed srtm file from cache..."
                os.remove("%s" % (tileFname))

        os.chdir(origWd)



    def getGridData(self,jobCfg):
        print "getGridData"
        createGridShapefile.createGridShapefile(jobCfg)

    def getMapnikStyleFile(self,jobCfg):
        print "getMapnikStyleFile"
        jobCfg['mapnikStyleFile'] = self.sysCfg['osmMapnikStyleFile']

        


if __name__ == "__main__":
    print "dataMgr.py"
    sysCfg = {}
    dm = dataMgr(sysCfg)
    print "done"

