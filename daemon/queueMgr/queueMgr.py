""" queueMgr is a class to enable python applications to interact with the
    printmaps API (http://github.com/jones139/disrend).

    Usage:     
    qm = queueMgr("www.maps.webhop.net","printmaps")
    jobNo = qm.getNextJobNo

    etc. etc.

"""

import httplib, urllib
import json

class queueMgr:
    """Job Queue Manager - retrieves jobs and uploads results to the server.""" 
    def __init__(self,serverURL,apiPrefix):
        """Initialise the queue manager.  serverURL is the url
        of the queue server (e.g. www.maps.webhop.net).
        apiPrefix is the directory on the server containing the api
        files (e.g. "printmaps" if the server API address is
        maps.webhop.net/printmaps
        """
        self.conn = httplib.HTTPConnection(serverURL)
        self.serverURL = serverURL
        self.apiPrefix = apiPrefix

        self.FILE_CONFIG = 1
        self.FILE_LOG = 2
        self.FILE_OUTPUT = 3
        self.FILE_THUMB = 4
    

    def getNextJobNo(self):
        """
        Returns an integer which is the job number of the next job
        to be processed in the queue, or zero if there is an error.
        """
        self.conn.request("GET", "/%s/getNextJob.php" % (self.apiPrefix))
        response = self.conn.getresponse()
        #print response.status, response.reason
        data = response.read()
        return int(data)

    def getJobInfo(self,jobNo,infoType):
        """
        Returns information about job number jobNo.
        infoType defines what information is returned:
        qm.FILE_CONFIG - the json configuration file (returned as an object).
        qm.FILE_LOG - the data processor log file.
        qm.FILE_OUTPUT - the main output of the data processor (pdf file)
        qm.FILE_THUMB - the thumbnail image of the output.
        """
        self.conn.request("GET", 
                          "/%s/getJobInfo.php?jobNo=%s&infoType=%s" % 
                          (self.apiPrefix,jobNo,infoType)
                          )
        response = self.conn.getresponse()
        #print response.status, response.reason
        data = response.read()
        return (data)

    def getJobConfig(self,jobNo):
        """
        Returns the configuration file for job number jobNo.
        This is equivalent to getJobInfo(jobNo,1).
        """
        data=self.getJobInfo(jobNo,self.FILE_CONFIG)
        return(json.loads(data))

    def claimJob(self,jobNo):
        """
        Tells the server that we are claiming this job for processing.
        """
        self.conn.request("GET", 
                          "/%s/claimJob.php?jobNo=%s" % 
                          (self.apiPrefix,jobNo)
                          )
        response = self.conn.getresponse()
        #print response.status, response.reason
        data = response.read()
        if (int(data) != jobNo):
            print "oh no - data=%s, jobNo=%s - something has gone wrong!\n" %\
                (data,jobNo)
            return False
        else:
            return True

    def uploadFile(self,jobNo,fname,ftype):
        """uploads the file 'fname' to the server, telling the server
        that the file is of type ftype, and that it is for job number jobNo.
        qm.FILE_LOG  - log file
        qm.FILE_OUTPUT  - main output (pdf file)
        qm.FILE_THUMB  - thumbnail image of output.
        """
        f = open(fname,'r')
        fileData = f.read()
        f.close()

        params = urllib.urlencode({'jobNo': jobNo, 'fileData': fileData, 'fileType': ftype})
        headers = {"Content-type": "application/x-www-form-urlencoded",
                   "Accept": "text/plain"}
        self.conn.request("POST", 
                          "/%s/uploadFile.php" % 
                          (self.apiPrefix),
                          params,
                          headers
                          )
        response = self.conn.getresponse()
        data = response.read()
        print data

    def quitQueueMgr(self):
        """
        Closes the connectino to the server
        """
        self.conn.close()



if __name__ == "__main__":
    print "queueMgr.py"
    qm = queueMgr("localhost","printmaps")
    jobNo = qm.getNextJobNo();
    print "jobNo=%d\n" % (jobNo)

    if (jobNo==0):
        print "No waiting Jobs...."
    else:
        print qm.claimJob(jobNo)
        jobInfo = qm.getJobInfo(jobNo,1)
        print "jobInfo=%s\n" % (jobInfo)

        jobConfig = qm.getJobConfig(jobNo)
        print jobConfig

        qm.uploadFile(jobNo,"queueMgr.py",2)

        jobInfo = qm.getJobInfo(jobNo,2)
        print "retrieved file is=%s\n" % (jobInfo)


        qm.quitQueueMgr()

