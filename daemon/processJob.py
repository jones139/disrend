import json,os
from pyproj import Proj
from queueMgr import queueMgr
from dataMgr import dataMgr
from paperSize import getPaperSize

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
        os.makedirs(self.jobCfg['jobDir'])
        configFname = "%s/%s" % (self.jobCfg['jobDir'],'config.json')
        f = open(configFname,'w')
        f.write(json.dumps(self.jobCfg))
        f.close()


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
            if (not self.qm.claimJob(jobNo)):
                print "Error Claiming Job - aborting..."
            else:
                print "job Claimed"
                self.jobCfg = self.qm.getJobConfig(jobNo)
                self.setupJobDir(jobNo)
                self.dm.getOSMData(self.jobCfg)
                self.dm.getSRTMData(self.jobCfg)
                self.dm.getGridData(self.jobCfg)
                self.dm.getMapnikStyleFile(self.jobCfg)
                print self.jobCfg['mapnikStyleFile']

                if (self.jobCfg['renderer']=="1"):
                    print "calling towngude renderer"
                    self.renderTownguide(jobNo)
                elif (self.jobCfg['renderer']=="2"):
                    print "calling mapbook renderer"
                    self.renderMapbook(jobNo)

                


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
