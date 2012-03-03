"""
dataMgr - manages map data ready for rendering using mapnik.
"""

class dataMgr:
    def __init__(self,sysCfg):
        print "dataMgr.__init__()"
        self.sysCfg = sysCfg
        print sysCfg

    def getOSMData(self,jobCfg):
        print "getOSMData"

    def getSRTMData(self,jobCfg):
        print "getSRTMData"

    def getGridData(self,jobCfg):
        print "getGridData"


    def getMapnikStyleFile(self,jobCfg):
        print "getMapnikStyleFile"
        jobCfg['mapnikStyleFile'] = self.sysCfg['osmMapnikStyleFile']

        


if __name__ == "__main__":
    print "dataMgr.py"
    sysCfg = {}
    dm = dataMgr(sysCfg)
    print "done"

