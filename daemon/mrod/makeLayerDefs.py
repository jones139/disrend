#!/usr/bin/python
'''
 NAME: makeLayerDefs.py
 DESC: Takes a JSON map specification (mapspec) and carries out the following
       actions:
       1.  Obtains the required data specified in the mapspec by downloading
           it from the server if necessary, and extracting it into the
           current working directory.
       2.  Creates a carto compatible JSON input file from the mapspec
           for rendering by carto/mapnik.

           Copyright Graham Jones, 2011
           This software is licenced under the Gnu Public License (GPL)
           version 3.
'''

def makeLayerDefs(mapSpecJSONFname, settingsJSONFname="./settings.json", verbose=False):
    #so = settingsObject
    so =  json.loads(settingsJSON)
    if (verbose): 
        print "Imported Settings as:\n%s\n" % (mso.__str__())

    # mso = mapSpecObject
    mso = json.loads(mapSpecJSON)
    if (verbose): 
        print "Imported Mapspec as:\n%s\n" % (mso.__str__())
    jobID = mso['jobID']
    projection = mso['projection']
    lat = mso['origin']['lat']
    lon = mso['origin']['lon']
    scale = mso['scale']

if __name__ == "__main__":
    print "makeLayerDefs"
    usage = "Usage %prog [options] mapspec"
    version = "0.1"
    parser = OptionParser(usage=usage,version=version)
    parser.add_option("-v", "--verbose", action="store_true",dest="verbose",
                     help="Include verbose output")
    parser.add_option("-d", "--debug", action="store_true",dest="debug",
                     help="Include debug output")
    parser.set_defaults(
        debug=False,
        verbose=False)
    (options,args)=parser.parse_args()
   
    if (options.debug):
        options.verbose = True
        print "options   = %s" % options
        print "arguments = %s" % args
   
    if len(args)==0:
        infname = "stdin"
    else:
        infname = args[0]

    if (options.verbose): print "infname = %s" % (infname)


