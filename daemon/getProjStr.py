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
