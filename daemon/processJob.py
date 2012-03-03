import json,os
from queueMgr import queueMgr
from dataMgr import dataMgr

class jobProcessor:
    def __init__(self,cfg):
        print "__init__"
        self.cfg = cfg
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
