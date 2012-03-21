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


####################################################################
def getPaperSize(paperObj,verbose=False):
    ''' 
    Returns the papersize (w,h) which is the width and height of the paper
    in cm, based on the definition in object paperObj.
    it expects the following:
        paperObj['size'] = 'A4' etc.
        paperObj['orientation'] = 'landscape'
    if paperObj['size'] is 'custom', it expects a 'w' and a 'h' entry
        for the width and height of the paper in cm.
    '''
    print "paperObj=%s." % (paperObj.__str__())
    # Defined paper sizes in cm - default orientation is portrait.
    sizes = {'A5':(7,10),
             'A4':(14,20),
             'A3':(28,40),
             'A2':(56,80),
             'A1':(112,160),
             'A0':(224,320)}

    if not 'size' in paperObj: paperObj['size'] = 'undefined'
    if paperObj['size'] in sizes:
        (w,h) = sizes[paperObj['size']]
        if 'orientation' in paperObj:
            if (verbose): 
                print 'orientation = %s.' % paperObj['orientation']
            if paperObj['orientation'] == 'landscape':
                (w,h)=(h,w)
    else:
        if (verbose): print "size %s not found"
        (w,h) = (300,300)
        if 'w' in paperObj: w=paperObj['w']
        if 'h' in paperObj: h=paperObj['h']
    return(w,h)


