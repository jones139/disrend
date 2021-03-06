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
#functions - from http://old.nabble.com/Download-file-via-HTTP-GET-with-progress-monitoring---custom-headers--td18917651.htmlimport urllib2
#
import os, sys
import urllib2

def reportDownloadProgress(blocknum, bs, size):
    percent = int(blocknum*bs*100/size)
    print str(blocknum*bs ) + '/' + str(size) + 'downloaded | ' + str(percent) + '%'
   
def httpDownload(url, filename, headers=None, reporthook=None, postData=None):
    print "httpDownload - url=%s." % (url)
    reqObj = urllib2.Request(url, postData, headers)
    fp = urllib2.urlopen(reqObj)
    headers = fp.info()
    ##    This function returns a file-like object with two additional methods:
    ##
    ##    * geturl() -- return the URL of the resource retrieved
    ##    * info() -- return the meta-information of the page, as a dictionary-like object
    ##
    ##Raises URLError on errors.
    ##
    ##Note that None may be returned if no handler handles the request (though the default installed global OpenerDirector uses UnknownHandler to ensure this never happens).

    #read & write fileObj to filename
    tfp = open(filename, 'wb')
    result = filename, headers
    bs = 1024*8
    size = -1
    read = 0
    blocknum = 0
   
    if reporthook:
        if "content-length" in headers:
            size = int(headers["Content-Length"])
        reporthook(blocknum, bs, size)
       
    while 1:
        block = fp.read(bs)
        if block == "":
            break
        read += len(block)
        tfp.write(block)
        blocknum += 1
        if reporthook:
            reporthook(blocknum, bs, size)
           
    fp.close()
    tfp.close()
    del fp
    del tfp

    # raise exception if actual size does not match content-length header
    if size >= 0 and read < size:
        raise ContentTooShortError("retrieval incomplete: got only %i out "
                                    "of %i bytes" % (read, size), result)

    return result
   
def downloadOsmData(sysCfg,jobCfg):
    '''
    Downloads OSM Data from the jxapi server and imports it into postgresql.
    '''
    print 'Using OSM JXAPI Server for data download'
    url="http://jxapi.openstreetmap.org/xapi/api/0.6/map?bbox=%f,%f,%f,%f" %\
        (jobCfg['ll'])
    headers = {
        'User-Agent' : 'Mozilla/4.0 (compatible; MSIE 5.5; Windows NT)',
        'Accept' :
            'text/xml,application/xml,application/xhtml+xml,text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5',
        'Accept-Language' : 'fr-fr,en-us;q=0.7,en;q=0.3',
        'Accept-Charset' : 'ISO-8859-1,utf-8;q=0.7,*;q=0.7'
        }


    osmFile = "%s/tmp.osm" % (jobCfg['jobDir'])

    httpDownload(url, osmFile, headers, reportDownloadProgress)

    if os.path.exists(osmFile):
        try:
            print 'Importing data into postgresql database....'
            osm2pgsqlStr = "osm2pgsql -m -S %s -d %s %s" %\
                (sysCfg['default.style'],
                 sysCfg['osm_db']['dbname'],
                 osmFile)
            print "Calling osm2pgsql with: %s" % osm2pgsqlStr
            retval = os.system(osm2pgsqlStr)
            if (retval==0):
                print 'Data import complete.'
            else:
                print 'osm2pgsql returned %d - exiting' % retval
                # system.exit(-1)
        except:
            print "Exception Occurred running osm2pgsql"
            print sys.exc_info()
            print "This means that the map is not likely to look right..."
    else:
        print "ERROR:  Failed to download OSM data"
        print "Aborting...."
        print "Unexpected error:", sys.exc_info()

    print "downloadOsmData Complete."

if __name__ == "__main__":
    ll = (-2,54,-1,55)
    downloadOsmData(ll)
