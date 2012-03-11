import mapnik2 as mapnik
import cairo
from paperSize import getPaperSize
from getProjStr import getProjStr

def simpleMapRenderer(jobCfg,sysCfg):
    print "simpleMapRenderer"
    
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
    mapnik_scale_factor = img_dpi / 90.7
    imgx = int(imgw * img_dpi / 2.54)
    imgy = int(imgh * img_dpi / 2.54)

    print "generating map...."
    m = mapnik.Map(imgx,imgy)
    mapnik.load_map(m,styleFname)
    bbox = mapnik.Box2d(c0.x,c0.y,c1.x,c1.y)
    m.zoom_to_box(bbox)
    im = cairo.PDFSurface(outputFname,imgx,imgy)
    mapnik.render(m, im)
    im.finish()

    print "done - image stored as %s" % outputFname



