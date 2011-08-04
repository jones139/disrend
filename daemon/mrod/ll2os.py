#!/usr/bin/python

# ll2os - converst from WGS84 (GPS) lat-long coordinates to OSGB grid
#          reference using proj4.
# Conversion from numeric reference to letter/number grid ref taken from
# http://www.movable-type.co.uk/scripts/latlong-gridref.html

import pyproj



def ll2osgb(lat,lon,ndig=6):
    p1 = pyproj.Proj("+proj=longlat +ellps=WGS84 +datum=WGS84 +no_defs") 
    p2 = pyproj.Proj("+proj=tmerc +lat_0=49 +lon_0=-2 +k=0.999601 +x_0=400000 +y_0=-100000 +ellps=airy +towgs84=446.448,-125.157,542.060,0.1502,0.2470,0.8421,-20.4894 +units=m +no_defs <>") # OSGB Grid Reference.
    x1 = float(srcCentx)
    y1 = float(srcCenty)
    e, n = pyproj.transform(p1, p2, x1, y1)

    print "(e,n) = %f, %f" % (e,n)
    
    e100k = int(e/100000)
    n100k = int(n/100000)
    
    print "(e100k,n100k) = %d, %d" % (e100k,n100k)

    if (e100k<0 or e100k>6 or n100k<0 or n100k>12):
        print "Error - reference out of range!!"
    else:
        print "reference in range - ok"

    l1 = (19-n100k) - (19-n100k)%5 + int((e100k+10)/5)
    l2 = (19-n100k)*5%25 +e100k%5

    if (l1>7): 
        l1=l1+1
    if (l2>7):
        l2=l2+1

    print "(l1,l2) = %d, %d" % (l1,l2)

    a1 = l1 + ord('A')
    a2 = l2 + ord('A')

    c1 = chr(a1)
    c2 = chr(a2)

    print "(c1,c2) = %c, %c" % (c1,c2)

    letters = c1+c2

  #// strip 100km-grid indices from easting & northing, and reduce precision
  #e = Math.floor((e%100000)/Math.pow(10,5-digits/2));
  #n = Math.floor((n%100000)/Math.pow(10,5-digits/2));

  #var gridRef = letPair + e.padLZ(digits/2) + n.padLZ(digits/2);

    e = str(int((e%100000)/pow(10,5-ndig/2)))
    n = str(int((n%100000)/pow(10,5-ndig/2)))

    print "(e,n) = %s, %s" % (e,n)

    gridRef = letters+e.zfill(ndig/2)+n.zfill(ndig/2)

    return(gridRef)

###################################################################
# Main program

srcCentx = -1.9
srcCenty = 54.5

print ll2osgb(srcCentx,srcCenty)

