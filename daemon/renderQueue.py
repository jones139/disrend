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
import os,sys
import json
import time
from processJob import jobProcessor

class renderQueue:
    def __init__(self,daemon,cFname,pidfile):
        
        if cFname==None:
            print "using default directories"
        else:
            print "reading directories from file %s." % cFname
            f = open(cFname,'r')
            cfgStr = f.read()
            f.close()
            self.cfgObj = json.loads(cfgStr)

        if (daemon):
            # do the UNIX double-fork magic, see Stevens' "Advanced
            # Programming in the UNIX Environment" for details (ISBN 0201563177)
            try:
                pid = os.fork()
                if pid > 0:
                    # exit first parent
                    sys.exit(0)
            except OSError, e:
                print >>sys.stderr, "fork #1 failed: %d (%s)" % (e.errno, e.strerror)
                sys.exit(1)

            # decouple from parent environment
            os.chdir("/")   #don't prevent unmounting....
            os.setsid()
            os.umask(0)

            # do second fork
            try:
                pid = os.fork()
                if pid > 0:
                    # exit from second parent, print eventual PID before
                    #print "Daemon PID %d" % pid
                    of = open(pidfile,'w')
                    of.write("%d"%pid)
                    of.close()
                    sys.exit(0)
            except OSError, e:
                print >>sys.stderr, "fork #2 failed: %d (%s)" % (e.errno, e.strerror)
                sys.exit(1)

            # start the daemon main loop
            retcode = 0
            print "createDaemon exited with retcode %d" % retcode
            self.queueLoop()
        else:
            self.queueLoop()


    def queueLoop(self):
        print "queueLoop"
        self.jp = jobProcessor(self.cfgObj)
        while(1):
            #try:
            self.jp.processJob()
            #except:
            #print "oh no -  error:", sys.exc_info()[0]
            time.sleep(5)


if __name__ == "__main__":
    from optparse import OptionParser

    usage = "Usage %prog [options]"
    version = "SVN Revision $Rev: 7 $"
    parser = OptionParser(usage=usage,version=version)
    parser.add_option("-d", "--daemon", action="store_true",dest="daemon",
                      help="Run as a daemon")
    parser.add_option("--logdir", dest="logdir",
                      help="not used")
    parser.set_defaults(
        cfname="./daemonCfg.json",
        daemon=False,
        pidfile="./renderQueue.pid",
        logdir=None)
    (options,args)=parser.parse_args()
    
    print
    print "%s %s" % ("%prog",version)
    print

    if not options.logdir == None:
        print "redirecting output to %s/renderQueue.log" % options.logdir
        logf = open("%s/renderQueue.log" % options.logdir,"w")
        sys.stdout = logf
        sys.stderr = logf
    else:
        print "Using standard input and output streams"

    print
    print options

    rq = renderQueue(options.daemon, options.cfname, options.pidfile)

    print "Well, the daemon should be running, exiting"
