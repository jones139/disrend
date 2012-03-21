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
import json,os,sys
from pyproj import Proj
from queueMgr import queueMgr
from dataMgr import dataMgr
from paperSize import getPaperSize
from simpleMapRenderer import simpleMapRenderer

class jobProcessor:
    def __init__(self,cfg):
        print "__init__"
        self.cfg = cfg
        self.sysCfg = cfg
        self.qm = queueMgr(self.cfg['server'],self.cfg['apiPrefix'])
        self.dm = dataMgr(self.cfg)

    def setupJobDir(self,jobNo):
        print "setupJobDir(%d)\n" % jobNo
        print self.cfg
        self.jobCfg['jobDir'] = "%s/%d" % (self.cfg['dataDir'],jobNo)
        if not os.path.exists(self.jobCfg['jobDir']):
            os.makedirs(self.jobCfg['jobDir'])
        configFname = "%s/%s" % (self.jobCfg['jobDir'],'config.json')
        f = open(configFname,'w')
        f.write(json.dumps(self.jobCfg))
        f.close()


    def renderSimpleMap(self,jobNo):
        print "renderSimpleMap"
        self.jobCfg['outputFname']='output.pdf'
        simpleMapRenderer(self.jobCfg,self.sysCfg)
        

    def renderMapbook(self,jobNo):
        print "renderMapbook"
        p1 = Proj(init='epsg:4326') # lat-lon
        p2 = Proj(init='epsg:900913') # Google spherical mercator.
        (x,y) = p2(float(self.jobCfg['mapCenterLon']),
                   float(self.jobCfg['mapCenterLat']))
        print (x,y)

        (w,h) = getPaperSize({'size':self.jobCfg['paperSize'],
                              'orientation':'portrait'},
                             True)
        print (w,h)
        w = w * 72 / 2.5   # convert from cm to points.
        h = h * 72 / 2.5   # convert from cm to points.

        print (w,h)

        cmdline = "%s --startx %f --starty %f --width %f --pagewidth %f --pageheight %f --rows %d --columns %d --mapfile %s --outputfile %s/output.pdf" % \
            (self.sysCfg['mapbook'],
             x,y,
             float(self.jobCfg['mapSizeW']),
             w,h,
             float(5),float(5),
             self.jobCfg['mapnikStyleFile'],
             self.jobCfg['jobDir']
             )
        print cmdline
        retval = os.system(cmdline)

    def renderTownguide(self,jobNo):
        print "renderTownguide"

    def processJob(self):
        """Gets the next waiting job off the queue
        and processes it.
        Just exits if there is no job waiting.
        """
        print "processJob()"
        jobNo = self.qm.getNextJobNo()

        if (jobNo > 0):
            print "processing Job Number %d" % jobNo
            try:
                if (not self.qm.claimJob(jobNo)):
                    print "Error Claiming Job - aborting..."
                else:
                    print "job Claimed"
                    self.jobCfg = self.qm.getJobConfig(jobNo)
                    self.jobCfg['jobNo'] = jobNo
                    self.setupJobDir(jobNo)
                    self.qm.setJobStatus(jobNo,self.qm.STATUS_RENDERING)
                    self.dm.setBbox(self.jobCfg)
                    if (self.sysCfg['downloadOSMData']):
                        print "Downloading OSM Data"
                        self.dm.getOSMData(self.sysCfg,self.jobCfg)
                    else:
                        print "Using OSM Data from existing database."

                    if (self.jobCfg['contours'] or 
                        self.jobCfg['hillshade']):
                        #pass
                        self.dm.getSRTMData(self.sysCfg,self.jobCfg)
                    if (self.jobCfg['grid']):
                        self.dm.getGridData(self.jobCfg)
                    self.dm.getMapnikStyleFile(self.jobCfg)
                    print self.jobCfg['mapnikStyleFile']

                    if (self.jobCfg['renderer']=="0"):
                        print "calling simple map renderer"
                        self.renderSimpleMap(jobNo)
                    elif (self.jobCfg['renderer']=="1"):
                        print "calling towngude renderer"
                        self.renderTownguide(jobNo)
                    elif (self.jobCfg['renderer']=="2"):
                        print "calling mapbook renderer"
                        self.renderMapbook(jobNo)

                    outputFname = str("%s/%s" % \
                                          (self.jobCfg['jobDir'],
                                           self.jobCfg['outputFname']))
                    self.qm.uploadFile(jobNo,
                                       outputFname,
                                       self.qm.FILE_OUTPUT)


                    thumbnailFname = str("%s/%s" % \
                                          (self.jobCfg['jobDir'],
                                           "thumbnail.png"))
                    convertStr = "convert -scale 100 %s %s" % (outputFname,
                                                               thumbnailFname)
                    print "Creating thumbnail using: %s" % convertStr
                    os.system(convertStr)

                    self.qm.uploadFile(jobNo,
                                       thumbnailFname,
                                       self.qm.FILE_THUMB)


                    self.qm.setJobStatus(jobNo,self.qm.STATUS_COMPLETE)
            except:
                self.qm.setJobStatus(jobNo,self.qm.STATUS_FAILED)
                print "Job Failed!"
                print "Unexpected error:", sys.exc_info()
                raise
                


        else:
            print "no Job in Queue - exiting"













if __name__ == "__main__":
    print "processJob.py"
    fname = "daemonCfg.json"
    f = open(fname,'r')
    cfgStr = f.read()
    f.close()

    cfgObj = json.loads(cfgStr)

    jp = jobProcessor(cfgObj)
    jp.processJob()
