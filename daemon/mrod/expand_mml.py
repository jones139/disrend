#!/usr/bin/python
#
# expand_mml - expands a carto layer definition JSON file (mml)
#              by replacing variables defined in the file.
#              Variables should be defined in a "variables" object such as:
#    "variables":{
#         $$datasource:":'"type":"postgis",
#	       "dbname":"mapnik",
#	       "user":"www",
#	       "password":"1234",
#	       "host":"localhost",
#	       "port":"",
#              '
#
#  here, any instances of the string $$datasource are replaced
#  with the specified multi-line string.
#
# HIST:
#    22sept2011  GJ  ORIGINAL VERSION
from optparse import OptionParser
import json


def expand_mml(infname,outfname,verbose=False,debug=False):
    if verbose: 
        print("expand_mml(%s,%s)\n" % (infname,outfname))

    if (infname=="stdin"):
        if (options.verbose): print "Reading from standard input - ctrl-d to finish"
        infile = sys.stdin
    else:
        infile = open(infname)

    mmlJSON = infile.read()
    mmlo = json.loads(mmlJSON)
    if (options.verbose): 
        print "Imported mml as:\n%s\n" % (mmlo.__str__())

    for layer in mmlo['Layer']:
        for item in layer:
            print item




##########################################################################
if __name__ == "__main__":
    print "expand_mml"

    usage = "Usage %prog [options] infile.mml outfile.mml"
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

    if len(args)<2:
        outfname = "stdout"
    else:
        outfname = args[1]

    if (options.verbose): print "infname = %s" % (infname)
    if (options.verbose): print "outfname = %s" % (outfname)

    expand_mml(infname, outfname,options.verbose,options.debug)







