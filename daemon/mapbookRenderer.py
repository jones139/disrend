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
import cairo
from paperSize import getPaperSize
from getProjStr import getProjStr
import os,fnmatch

def mapbookRenderer(jobCfg,sysCfg):
    print "mapbookRenderer"
    
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
    styleFname = str(jobCfg['mapnikStyleFile'])
    outputFname = str("%s/%s" % \
        (jobCfg['jobDir'],jobCfg['outputFname']))
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


    cmdLine = "mapbook/run_mapbook.py "
    cmdLine += " --startx %f" % c0.x
    cmdLine += " --starty %f" % c0.y
    cmdLine += " --width %f" % mapw
    cmdLine += " --height %f" % maph
    cmdLine += " --outputfile %s " % outputFname
    cmdLine += " --mapfile %s " % styleFname

    print cmdLine
    os.system(cmdLine)

    print "done - image stored as %s" % outputFname



