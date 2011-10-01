import json
import os
import copy

validLayers = {"coastline":"OSM processed_p shape file coastlines",
               "osm_landuse":"All polygons tagged with a landuse= tag",
               "osm_natural":"All points, lines and polygons tagged with a natural= tag",
               "osm_amenity":"All points, lines and polygons tagged with an amenity= tag",
               "osm_roads":"All lines tagged with highway= tags",
               "osm_paths":"All lines tagged with highway='path|footway|cycleway|track|bridleway|public_bridleway|public_footpath",

               "vmd_woodland":"OS Vector Map district Woodland area data",
               "vmd_water": "OS Vector Map district water lines and areas",
               "vmd_ornament": "OS Vector Map District ornament areas",
               "vmd_buildings": "OS Vector Map District Building areas",
               "vmd_rail": "OS Vector Map District Railway Tracks",
               "vmd_roads": "OS Vector Map District roads",
               "vmd_electricity": "OS Vector Map District Electricity Lines",
               "vmd_places": "OS Vector Map District Place Names",



               "contours": "Contour lines generated from SRTM data.",
               "hillshading": "Hill shading generated from SRTm data."
               }

def mkLayerDict(layerId=None, 
                 name=None, 
                 srs=None, 
                 className=None, 
                 geometry=None,
                 datasource=None):
    layerDict = {}
    layerDict['id']=layerId
    layerDict['name']=name
    layerDict['srs']=srs
    layerDict['class']=className
    layerDict['geometry']=geometry
    layerDict['Datasource']=datasource
    return layerDict

def mkOSMDataSource(dbDict,selectStr):
    retDict = copy.deepcopy(dbDict)
    retDict['table']=selectStr
    return retDict


def mkStyleList(stylePath="."):
    dirList = os.listdir(stylePath)
    styleList = []
    for fname in dirList:
        if ".mss" in fname:
            print "found style %s" % (fname)
            styleList.append(fname)
    styleList.sort()
    return styleList
        


def createMml(baseMap,layerNamesArr, gridSquareList,defaults):
    '''
    baseMap = filename for mml file.
    layerNamesArr = array of layers to be included in mml file.
    gridSquareList = array of OS grid squares covered by map request
    defaults = dictionary of default values
    '''
    osmProj = "+proj=merc +a=6378137 +b=6378137 +lat_ts=0.0 +lon_0=0.0 +x_0=0.0 +y_0=0 +k=1.0 +units=m +nadgrids=@null +no_defs"
    latLonProj = "+proj=latlong +datum=WGS84"
    osProj =  "+proj=tmerc +lat_0=49 +lon_0=-2 +k=0.999601 +x_0=400000 +y_0=-100000 +ellps=airy +units=m +datum=OSGB36 +no_defs no_defs"


    print "createMml - basemap=%s" % baseMap
    print "defaults=",defaults['osm_db']
    layersArr = []
    for layer in layerNamesArr:
        if layer == "coastline":
            print "Coastline Found"
            lo = mkLayerDict("coastline",
                          "coastline",
                          osmProj,
                          "coastline",
                          "polygon",
                          {"file":"%s/processed_p.shp" % defaults['world_boundaries'],"type":"shape"})
            layersArr.append(lo)
            ########################################################
        elif layer == "osm_landuse":
            print "%s found" % layer
            lo = mkLayerDict("osm_landuse_poly",
                             "osm_landuse_poly",
                             osmProj,
                             "osm_landuse",
                             "polygon",
                             mkOSMDataSource(defaults['osm_db'],
                                             "(select way,landuse,name from planet_osm_polygon where (landuse is not null)) as landuse")
                             )
            layersArr.append(lo)
            ######################################################
        elif layer == "osm_natural":
            print "%s found" % layer
            lo = mkLayerDict("osm_natural_poly",
                             "osm_natural_poly",
                             osmProj,
                             "osm_natural",
                             "polygon",
                             mkOSMDataSource(defaults['osm_db'],
                                             '(select way,"natural",name from planet_osm_polygon where  "natural" is not null) as "natural"')
                             )
            layersArr.append(lo)
            lo = mkLayerDict("osm_natural_line",
                             "osm_natural_line",
                             osmProj,
                             "osm_natural",
                             "line",
                             mkOSMDataSource(defaults['osm_db'],
                                             '(select way,"natural",name from planet_osm_line where  "natural" is not null) as "natural"')
                             )
            layersArr.append(lo)
            lo = mkLayerDict("osm_natural_point",
                             "osm_natural_point",
                             osmProj,
                             "osm_natural",
                             "point",
                             mkOSMDataSource(defaults['osm_db'],
                                             '(select way,"natural",name from planet_osm_point where  "natural" is not null) as "natural"')
                             )
            layersArr.append(lo)
            ###########################################################
        elif layer == "osm_amenity":
            print "%s found" % layer
            lo = mkLayerDict("osm_amenity_poly",
                             "osm_amenity_poly",
                             osmProj,
                             "osm_amenity",
                             "polygon",
                             mkOSMDataSource(defaults['osm_db'],
                                             '(select way,amenity,name from planet_osm_polygon where amenity is not null) as amenity')
                             )
            layersArr.append(lo)
            lo = mkLayerDict("osm_amenity_line",
                             "osm_amenity_line",
                             osmProj,
                             "osm_amenity",
                             "line",
                             mkOSMDataSource(defaults['osm_db'],
                                             '(select way,amenity,name from planet_osm_line where amenity is not null) as amenity')
                             )
            layersArr.append(lo)
            lo = mkLayerDict("osm_amenity_point",
                             "osm_amenity_point",
                             osmProj,
                             "osm_amenity",
                             "point",
                             mkOSMDataSource(defaults['osm_db'],
                                             '(select way,amenity,name from planet_osm_point where amenity is not null) as amenity')
                             )
            layersArr.append(lo)
            #############################################################
        elif layer == "osm_roads":
            print "%s found" % layer
            lo = mkLayerDict("osm_highways",
                             "osm_highways",
                             osmProj,
                             "osm_highways",
                             "line",
                             mkOSMDataSource(defaults['osm_db'],
                                             '(select way,planet_osm_line.highway,name,ref,priority from planet_osm_line join highway_priorities on (planet_osm_line.highway=highway_priorities.highway) where planet_osm_line.highway is not null order by priority desc) as highways'
                             ))
            layersArr.append(lo)
            ###############################################################
        elif layer == "osm_paths":
            print "%s found" % layer
            lo = mkLayerDict("osm_paths",
                             "osm_paths",
                             osmProj,
                             "osm_paths",
                             "line",
                             mkOSMDataSource(defaults['osm_db'],
                                             "(select way,planet_osm_line.highway,name,ref,priority from planet_osm_line join highway_priorities on (planet_osm_line.highway=highway_priorities.highway) where planet_osm_line.highway in ('path','footway','cycleway','track','bridleway','public_bridleway','public_footpath') order by priority desc) as highways"))
            layersArr.append(lo)
            ###############################################################
        elif layer == "vmd_woodland":
            print "%s found" % layer

            for gs in gridSquareList:
                lo = mkLayerDict("vmd_woodland_%s" % gs,
                          "vmd_woodland_%s" % gs,
                          osProj,
                          "vmd_woodland",
                          "area",
                          {"file":"%s/%s/%s_Woodland.shp" % 
                           (defaults['vmd_path'],
                            gs,gs),
                           "type":"shape"})
                layersArr.append(lo)
            ###############################################################
        elif layer == "vmd_water":
            print "%s found" % layer

            for gs in gridSquareList:
                lo = mkLayerDict("vmd_water_line_%s" % gs,
                          "vmd_water_line_%s" % gs,
                          osProj,
                          "vmd_water_line",
                          "line",
                          {"file":"%s/%s/%s_SurfaceWater_Line.shp" % 
                           (defaults['vmd_path'],
                            gs,gs),
                           "type":"shape"})
                layersArr.append(lo)
            for gs in gridSquareList:
                lo = mkLayerDict("vmd_water_area_%s" % gs,
                          "vmd_water_area_%s" % gs,
                          osProj,
                          "vmd_water_area",
                          "area",
                          {"file":"%s/%s/%s_SurfaceWater_Area.shp" % 
                           (defaults['vmd_path'],
                            gs,gs),
                           "type":"shape"})
                layersArr.append(lo)
            ###############################################################
        elif layer == "vmd_ornament":
            print "%s found" % layer
            for gs in gridSquareList:
                lo = mkLayerDict("vmd_ornament_%s" % gs,
                          "vmd_ornament_%s" % gs,
                          osProj,
                          "vmd_ornament",
                          "line",
                          {"file":"%s/%s/%s_Ornament.shp" % 
                           (defaults['vmd_path'],
                            gs,gs),
                           "type":"shape"})
                layersArr.append(lo)
            ###############################################################
        elif layer == "vmd_buildings":
            print "%s found" % layer

            for gs in gridSquareList:
                lo = mkLayerDict("vmd_buildings_%s" % gs,
                          "vmd_buildings_%s" % gs,
                          osProj,
                          "vmd_buildings",
                          "area",
                          {"file":"%s/%s/%s_Building.shp" % 
                           (defaults['vmd_path'],
                            gs,gs),
                           "type":"shape"})
                layersArr.append(lo)
            ###############################################################
        elif layer == "vmd_rail":
            print "%s found" % layer
            for gs in gridSquareList:
                lo = mkLayerDict("vmd_rail_%s" % gs,
                          "vmd_rail_%s" % gs,
                          osProj,
                          "vmd_rail",
                          "line",
                          {"file":"%s/%s/%s_RailwayTrack.shp" % 
                           (defaults['vmd_path'],
                            gs,gs),
                           "type":"shape"})
                layersArr.append(lo)
            ###############################################################
        elif layer == "vmd_roads":
            print "%s found" % layer
            for gs in gridSquareList:
                lo = mkLayerDict("vmd_roads_%s" % gs,
                          "vmd_roads_%s" % gs,
                          osProj,
                          "vmd_roads",
                          "line",
                          {"file":"%s/%s/%s_Road.shp" % 
                           (defaults['vmd_path'],
                            gs,gs),
                           "type":"shape"})
                layersArr.append(lo)
            ###############################################################
        elif layer == "vmd_electricity":
            print "%s found" % layer
            for gs in gridSquareList:
                lo = mkLayerDict("vmd_electricity_%s" % gs,
                          "vmd_electricity_%s" % gs,
                          osProj,
                          "vmd_electricity",
                          "line",
                          {"file":"%s/%s/%s_ElectricityTransmissionLine.shp" % 
                           (defaults['vmd_path'],
                            gs,gs),
                           "type":"shape"})
                layersArr.append(lo)
            ###############################################################
        elif layer == "vmd_places":
            print "%s found" % layer
            for gs in gridSquareList:
                lo = mkLayerDict("vmd_places_%s" % gs,
                          "vmd_places_%s" % gs,
                          osProj,
                          "vmd_places",
                          "point",
                          {"file":"%s/%s/%s_NamedPlace.shp" % 
                           (defaults['vmd_path'],
                            gs,gs),
                           "type":"shape"})
                layersArr.append(lo)
            ###############################################################
        elif layer == "vmd_heights":
            print "%s found" % layer
            for gs in gridSquareList:
                lo = mkLayerDict("vmd_heights_%s" % gs,
                          "vmd_heights_%s" % gs,
                          osProj,
                          "vmd_heights",
                          "point",
                          {"file":"%s/%s/%s_SpotHeight.shp" % 
                           (defaults['vmd_path'],
                            gs,gs),
                           "type":"shape"})
                layersArr.append(lo)
            ###############################################################
        elif layer == "contours":
            print "%s found" % layer
            lo = mkLayerDict("contours",
                          "contours",
                          latLonProj,
                          "contours",
                          "polygon",
                          {"file":"%s/%s" % 
                           (defaults['srtm_path'],
                            defaults['contoursShp']),
                           "type":"shape"})
            layersArr.append(lo)
            ###############################################################
        elif layer == "hillshading":
            print "%s found" % layer
            lo = mkLayerDict("hillshade",
                          "hillshade",
                          osmProj,
                          "hillshade",
                          "raster",
                          {"file":"%s/%s" 
                           % (defaults['srtm_path'], 
                              defaults['hillshadeTif']),
                           "type":"gdal"})
            layersArr.append(lo)
            ###############################################################
        elif layer == "grid":
            print "%s found" % layer
            lo = mkLayerDict("grid",
                          "grid",
                          osmProj,
                          "grid",
                          "line",
                          {"file":"./grid.shp" ,
                           "type":"shape"})
            layersArr.append(lo)
            ###############################################################
        else:
            print "Error - Layer %s unrecognised!!!!" % layer



    #######################################################################
    # Generate the list of style files to use by searching the working 
    # directory for .mss files.
    #
    styleList = mkStyleList()

    #######################################################################
    # Now write the mml file to disk
    #
    mmlDict = {"srs":"+proj=merc +a=6378137 +b=6378137 +lat_ts=0.0 +lon_0=0.0 +x_0=0.0 +y_0=0 +k=1.0 +units=m +nadgrids=@null +no_defs",
               "Stylesheet":styleList,
               "Layer":layersArr}
    print "Layers JSON = ", json.dumps(mmlDict,indent=4,sort_keys=True)

    baseMapFile = open(baseMap,"w")
    baseMapFile.write(json.dumps(mmlDict,indent=4,sort_keys=True))
    baseMapFile.close


