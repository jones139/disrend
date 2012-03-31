#!/usr/bin/python
#
#    This file is part of printmaps - a simple utility to produce a
#    printable (pdf) maps from OpenStreetMap data.
#
#    Printmaps is free software: you can redistribute it and/or modify
#    it under ther terms of the GNU General Public License as published by
#    the Free Software Foundation, either version 3 of the License, or
#    (at your option) any later version.
#
#    Printmaps is distributed in the hope that it will be useful,
#    but WITHOUT ANY WARRANTY; without even the implied warranty of
#    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#    GNU General Public License for more details.
#
#    You should have received a copy of the GNU General Public License
#    along with townguide.  If not, see <http://www.gnu.org/licenses/>.
#
#    Copyright Graham Jones 2009, 2010, 2012
#
import mapnik2 as mapnik
from paperSize import getPaperSize
from getProjStr import getProjStr
import os,fnmatch

def createMapnikXML(jobCfg,sysCfg):
    ''' Modifies the base mapnik xml style sheet to add layers
    for the grid, hillshading and contour lines as requested by the user
    in the jobCfg object.'''
    print "createMapnikXML"
    
    print "Imported settings as:\n%s\n" % (sysCfg.__str__())
    print "Imported Mapspec as:\n%s\n" % (jobCfg.__str__())
    jobNo = jobCfg['jobNo']
    projection = jobCfg['projection']
    lat = float(jobCfg['origin']['lat'])
    lon = float(jobCfg['origin']['lon'])
    scale = float(jobCfg['mapScale'])
    paper = jobCfg['paper']['size']
    if 'resolution' in jobCfg: 
        img_dpi = float(jobCfg['resolution'])
    else:
        img_dpi = 300
    styleFname = str(jobCfg['baseMapnikStyleFile'])
    
    outputFname = str("%s/%s" % \
        (jobCfg['jobDir'],"mapnikStyle.xml"))
    jobCfg['mapnikStyleFile']=outputFname
    print "jobNo = %d." % (jobNo)
    print "origin = (%f,%f)." % (lon,lat)
    print "scale = %f." % (scale)
    print "paper = %s." % (paper)

    (imgw,imgh) = getPaperSize(jobCfg['paper'])
    print "(imgw,imgh) = (%f,%f)." % (imgw,imgh)
    
    projStr = getProjStr(jobCfg['projection']);
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

    # Calculate the image size based on the required physical width and
    # height, and the requested resolution (img_dpi).
    #mapnik_scale_factor = img_dpi / 90.7
    mapnik_scale_factor = 1.0
    imgx = int(imgw * 72 / 2.54) # size in points (72nds of an inch).
    imgy = int(imgh * 72 / 2.54) # ~

    print "generating map...."
    m = mapnik.Map(imgx,imgy)
    mapnik.load_map(m,styleFname)

    if (jobCfg['hillshade']):
        ######################################
        # First get list of all the hillshade 
        # files in the job directory
        hillshadeFiles = []
        for file in os.listdir(jobCfg['jobDir']):
            if fnmatch.fnmatch(file,'*.hillshade.tiff'):
                print "found hillshade file %s\n" % file
                hillshadeFiles.append(file)

        if len(hillshadeFiles) == 0:
            print "*******ERROR - NO HILLSHADE FILES *****"
            print "* Will carry on anyway..."

        #############################################
        # Now add a mapnik style for the hillshading
        style = mapnik.Style()
        rule = mapnik.Rule()
        rs = mapnik.RasterSymbolizer()
        rs.opacity=0.5
        rule.symbols.append(rs)
        style.rules.append(rule)
        m.append_style('hillshade',style)
        ############################################
        # And a layer for each hillshade file
        i=0
        for file in hillshadeFiles:
            lyr = mapnik.Layer('hillshade-%d' % i)
            lyr.srs="+proj=merc +ellps=sphere +R=6378137 +a=6378137 +units=m"
            hillshadeFile="%s/%s" % (jobCfg['jobDir'],file)
            print "hillshadeFile=%s" % (hillshadeFile)
            ds = mapnik.Gdal(base=jobCfg['jobDir'],file=hillshadeFile.encode('utf-8'))
            ds.opacity = 0.5
            lyr.datasource = ds
            lyr.styles.append('hillshade')
            # m.layers.append(lyr)
            m.layers[7:7]=lyr
            i = i+1

    if (jobCfg['contours']):
        ######################################
        # First get list of all the contours 
        # files in the job directory
        contourFiles = []
        for file in os.listdir(jobCfg['jobDir']):
            if fnmatch.fnmatch(file,'*.contours.shp'):
                print "found contours file %s\n" % file
                contourFiles.append(file)

        if len(contourFiles) == 0:
            print "*******ERROR - NO CONTOUR FILES *****"
            print "* Will carry on anyway..."

        #############################################
        # Now add a mapnik style for the contours
        style = mapnik.Style()
        rule = mapnik.Rule()
        contourlines = mapnik.LineSymbolizer(mapnik.Color('green'),0.1)
        rule.symbols.append(contourlines)
        style.rules.append(rule)
        m.append_style('contours',style)
        ############################################
        # And a layer for each hillshade file
        i = 0
        for file in contourFiles:
            contourFile="%s/%s" % (jobCfg['jobDir'],file)
            print "contourFile=%s\n" % contourFile
            lyr = mapnik.Layer('contours-%d' % i)
            lyr.datasource = mapnik.Shapefile(file=contourFile.encode('utf-8'))
            lyr.styles.append('contours')
        #m.layers.append(lyr)
            m.layers[8:8]=lyr
            i = i + 1

    if (jobCfg['grid']):
        style = mapnik.Style()
        rule = mapnik.Rule()
        gridlines = mapnik.LineSymbolizer(mapnik.Color('white'),0.1)
        rule.symbols.append(gridlines)
        style.rules.append(rule)
        m.append_style('grid',style)
        gridFile="%s/%s" % (jobCfg['jobDir'],'grid.shp')
        print "gridFile=%s\n" % gridFile
        lyr = mapnik.Layer('grid')
        lyr.srs = "+proj=merc +ellps=sphere +R=6378137 +a=6378137 +units=m"
        lyr.datasource = mapnik.Shapefile(file=gridFile.encode('utf-8'))
        lyr.styles.append('grid')
        m.layers.append(lyr)
        
    i = 0
    for lyr in m.layers:
        print i,lyr.name
        i=i+1

    mapnik.save_map(m,outputFname)




