#!/usr/bin/python

# ll2os - converst from WGS84 (GPS) lat-long coordinates to OSGB grid
#          reference using proj4.
# Conversion from numeric reference to letter/number grid ref taken from
# http://www.movable-type.co.uk/scripts/latlong-gridref.html

import pyproj

debug=False

def ll2osgb(lon,lat,ndig=6):
    '''Return the OSGB Grid Reference of the point at position lon,lat degrees.
    the optional argument ndig is the number of digits to use in the grid 
    reference (default=6).
    '''
    p1 = pyproj.Proj("+proj=longlat +ellps=WGS84 +datum=WGS84 +no_defs") 
    p2 = pyproj.Proj("+proj=tmerc +lat_0=49 +lon_0=-2 +k=0.999601 +x_0=400000 +y_0=-100000 +ellps=airy +towgs84=446.448,-125.157,542.060,0.1502,0.2470,0.8421,-20.4894 +units=m +no_defs <>") # OSGB Grid Reference.
    x1 = float(lon)
    y1 = float(lat)
    e, n = pyproj.transform(p1, p2, x1, y1)

    if (debug): print "(e,n) = %f, %f" % (e,n)
    
    e100k = int(e/100000)
    n100k = int(n/100000)
    
    if (debug): print "(e100k,n100k) = %d, %d" % (e100k,n100k)

    if (e100k<0 or e100k>6 or n100k<0 or n100k>12):
        print "Error - reference out of range!!"
    else:
        if (debug): print "reference in range - ok"

    l1 = (19-n100k) - (19-n100k)%5 + int((e100k+10)/5)
    l2 = (19-n100k)*5%25 +e100k%5

    if (l1>7): 
        l1=l1+1
    if (l2>7):
        l2=l2+1

    if (debug): print "(l1,l2) = %d, %d" % (l1,l2)

    a1 = l1 + ord('A')
    a2 = l2 + ord('A')

    c1 = chr(a1)
    c2 = chr(a2)

    if (debug): print "(c1,c2) = %c, %c" % (c1,c2)

    letters = c1+c2

  #// strip 100km-grid indices from easting & northing, and reduce precision
  #e = Math.floor((e%100000)/Math.pow(10,5-digits/2));
  #n = Math.floor((n%100000)/Math.pow(10,5-digits/2));

  #var gridRef = letPair + e.padLZ(digits/2) + n.padLZ(digits/2);

    e = str(int((e%100000)/pow(10,5-ndig/2)))
    n = str(int((n%100000)/pow(10,5-ndig/2)))

    if (debug): print "(e,n) = %s, %s" % (e,n)

    gridRef = letters+e.zfill(ndig/2)+n.zfill(ndig/2)

    return(gridRef)


def ll2gridSquare(lon,lat):
    '''Returns the OSGB grid square identifier (e.g. NZ) that contains the 
    given point in degrees lon,lat.
    '''
    gridRef = ll2osgb(lon,lat)
    gridSquare = gridRef[0:2]
    return gridSquare


def bbox2gridList(ll):
    '''Returns a list of grid squares required to cover the given bounding box
    in lon,lat coordinates (bottom left, top right).  
    FIXME - this does not work - just returns the squares containing the
    four corners - needs to fill in if a large map is requested...!!!
    '''
    print "bbox2gridList:",ll
    gridList=[]

    bl = ll2gridSquare(ll[0],ll[1])
    gridList.append(bl)

    br = ll2gridSquare(ll[2],ll[1])
    tl = ll2gridSquare(ll[0],ll[3])
    tr = ll2gridSquare(ll[2],ll[3])

    if (not br in gridList):
        gridList.append(br)
    if (not tl in gridList):
        gridList.append(tl)
    if (not tr in gridList):
        gridList.append(tr)


    return gridList
    
                    


###################################################################
# Main program

##########################################################################
if __name__ == "__main__":
    bbox = (-1.9, 54.5, -1.0, 60.0)

    print ll2osgb(bbox[0],bbox[1])

    print ll2gridSquare(bbox[0],bbox[1])

    print bbox2gridList(bbox)

