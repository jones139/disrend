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
#!/usr/bin/python

import math
from osgeo import ogr
from osgeo import osr
import os

import mapnik2 as mapnik
###########################################################################
def createGridShapefile(jobCfg):
    ''' creates a shapefile of a grid of size girdSize metres covering
    the bounding box ll.
    '''
    print "createGridShapefile"

    ll = jobCfg['ll']                     # lat,lon bounding box.
    origWd = os.getcwd()
    os.chdir(jobCfg['jobDir'])

    try:
        gridSize = float(jobCfg['gridSpacing'])*1000.   # grid spacing in metres.
    except:
        print "****ERROR gridSize %s not recognised - using default ****" %\
            (jobCfg['gridSpacing'])
        gridSize = 1000.

    try:
        spherical_merc = mapnik.Projection('+init=epsg:900913')
    except: # you don't have 900913 in /usr/share/proj/epsg
        spherical_merc = mapnik.Projection('+proj=merc +a=6378137 +b=6378137 +lat_ts=0.0 +lon_0=0.0 +x_0=0.0 +y_0=0 +k=1.0 +units=m +nadgrids=@null +no_defs +over')
    try:
        longlat = mapnik.Projection('+init=epsg:4326')
    except: # your proj4 files are broken
        longlat = mapnik.Projection('+proj=longlat +ellps=WGS84 +datum=WGS84 +no_defs')
    from_srs,to_srs = longlat, spherical_merc
    ct = mapnik.ProjTransform(from_srs,to_srs)

    longlat_coords = mapnik.Coord(ll[0],ll[1])
    merc_coords = ct.forward(longlat_coords)
    print 'merc_coords:', merc_coords

    longlat_coords = ct.backward(merc_coords)
    print 'longlat_coords:',longlat_coords

    longlat_topright = mapnik.Coord(ll[2],ll[3])
    merc_topright = ct.forward(longlat_topright)
    print 'merc_topright:',merc_topright

    gridXRange = int((merc_topright.x - merc_coords.x) / gridSize)+1
    gridYRange = int((merc_topright.y - merc_coords.y) / gridSize)+1

    print 'gridXrange: %d, gridYrange:%d' % (gridXRange, gridYRange)

    sref=osr.SpatialReference()
    sref.ImportFromEPSG(900913)
    filename = 'grid.shp'
    driver = ogr.GetDriverByName('ESRI Shapefile')
    print "filename=%s\n" % filename
    driver.DeleteDataSource(filename)
    ds = driver.CreateDataSource(filename)
    layer = ds.CreateLayer('grid', geom_type=ogr.wkbLineString)
    fd = ogr.FieldDefn('TYPE', ogr.OFTInteger)
    fd.SetWidth(1)
    fd.SetPrecision(0)
    layer.CreateField(fd)
    fd = ogr.FieldDefn('VALUE', ogr.OFTInteger)
    fd.SetWidth(4)
    fd.SetPrecision(0)
    layer.CreateField(fd)
    fd = ogr.FieldDefn('ABS_VALUE', ogr.OFTInteger)
    fd.SetWidth(4)
    fd.SetPrecision(0)
    layer.CreateField(fd)

    xMin = merc_coords.x
    xMax = merc_coords.x + gridSize * gridXRange
    for gridy in range (0,gridYRange+1):
        y = gridy * gridSize + merc_coords.y
        line = ogr.Geometry(type=ogr.wkbLineString)
        line.AddPoint(xMin, y)
        line.AddPoint(xMax, y)
        f = ogr.Feature(feature_def=layer.GetLayerDefn())
        f.SetField(0, 0)
        f.SetField(1, y)
        f.SetField(2, math.fabs(y))
        f.SetGeometryDirectly(line)
        layer.CreateFeature(f)
        f.Destroy()

    yMin = merc_coords.y
    yMax = merc_coords.y + gridSize * gridYRange
    for gridx in range (0,gridXRange+1):
        x = gridx * gridSize + merc_coords.x
        line = ogr.Geometry(type=ogr.wkbLineString)
        line.AddPoint(x, yMin)
        line.AddPoint(x, yMax)
        f = ogr.Feature(feature_def=layer.GetLayerDefn())
        f.SetField(0, 1)
        f.SetField(1, x)
        f.SetField(2, math.fabs(x))
        f.SetGeometryDirectly(line)
        layer.CreateFeature(f)
        f.Destroy()

    ds.Destroy()
    os.chdir(origWd)


if __name__ == "__main__":
    ll = (-2,54,-1,55)
    gridSize = 1000
    createGridShapefile(ll,gridSize)
