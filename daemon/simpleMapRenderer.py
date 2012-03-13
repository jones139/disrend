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
    #mapnik_scale_factor = img_dpi / 90.7
    mapnik_scale_factor = 1.0
    imgx = int(imgw * 72 / 2.54) # size in points (72nds of an inch).
    imgy = int(imgh * 72 / 2.54) # ~

    print "generating map...."
    m = mapnik.Map(imgx,imgy)
    mapnik.load_map(m,styleFname)

    if (jobCfg['hillshade']):
        style = mapnik.Style()
        rule = mapnik.Rule()
        rs = mapnik.RasterSymbolizer()
        rs.opacity=0.5
        rule.symbols.append(rs)
        style.rules.append(rule)
        m.append_style('hillshade',style)
        lyr = mapnik.Layer('hillshade')
        lyr.srs="+proj=merc +ellps=sphere +R=6378137 +a=6378137 +units=m"
        hillshadeFile="%s/%s" % (jobCfg['jobDir'],'hillshade.tiff')
        print "hillshadeFile=%s" % hillshadeFile
        ds = mapnik.Gdal(base=jobCfg['jobDir'],file=hillshadeFile.encode('utf-8'))
        ds.opacity = 0.1
        lyr.datasource = ds
        lyr.styles.append('hillshade')
        m.layers.append(lyr)

    if (jobCfg['contours']):
        style = mapnik.Style()
        rule = mapnik.Rule()
        contourlines = mapnik.LineSymbolizer(mapnik.Color('green'),0.1)
        rule.symbols.append(contourlines)
        style.rules.append(rule)
        m.append_style('contours',style)
        contourFile="%s/%s" % (jobCfg['jobDir'],'contours.shp')
        print "contourFile=%s\n" % contourFile
        lyr = mapnik.Layer('contours')
        lyr.datasource = mapnik.Shapefile(file=contourFile.encode('utf-8'))
        lyr.styles.append('contours')
        m.layers.append(lyr)


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


    bbox = mapnik.Box2d(c0.x,c0.y,c1.x,c1.y)
    m.zoom_to_box(bbox)
    im = cairo.PDFSurface(outputFname,imgx,imgy)
    mapnik.render(m, im)
    im.finish()

    print "done - image stored as %s" % outputFname



