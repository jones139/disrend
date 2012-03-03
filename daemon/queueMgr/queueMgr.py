import httplib, urllib
import json

class queueMgr:
    """Job Queue Manager - retrieves jobs and uploads results to the server.""" 
    def __init__(self,serverURL,apiPrefix):
        self.conn = httplib.HTTPConnection(serverURL)
        self.serverURL = serverURL
        self.apiPrefix = apiPrefix
    

    def getNextJobNo(self):
        self.conn.request("GET", "/%s/getNextJob.php" % (self.apiPrefix))
        response = self.conn.getresponse()
        #print response.status, response.reason
        data = response.read()
        return int(data)

    def getJobInfo(self,jobNo,infoType):
        self.conn.request("GET", 
                          "/%s/getJobInfo.php?jobNo=%s&infoType=%s" % 
                          (self.apiPrefix,jobNo,infoType)
                          )
        response = self.conn.getresponse()
        #print response.status, response.reason
        data = response.read()
        return (data)

    def getJobConfig(self,jobNo):
        data=self.getJobInfo(jobNo,1)
        return(json.loads(data))

    def claimJob(self,jobNo):
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
        that the file is of type ftype, and that it is for job number jobNo."""
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
        self.conn.close()



if __name__ == "__main__":
    print "queueMgr.py"
    qm = queueMgr("www.maps.webhop.net","printmaps")
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

#params = urllib.urlencode({'@number': 12524, '@type': 'issue', '@action': 'show'})
#headers = {"Content-type": "application/x-www-form-urlencoded",
#           "Accept": "text/plain"}
#conn = httplib.HTTPConnection("www.maps.webhop.net")
#conn.request("GET", "/printmaps/getNextJob.php")
#response = conn.getresponse()
#print response.status, response.reason
#data = response.read()
#print dir(data)
#print data
#conn.close()
