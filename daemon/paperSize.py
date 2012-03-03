

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


