# 
# Copyright (C) 2010  Waldemar Quevedo
# Copyright     2011  Graham Jones

# This program is free software: you can redistribute it and/or modify
# it under the terms of the GNU Affero General Public License as
# published by the Free Software Foundation, either version 3 of the
# License, or any later version.

# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU Affero General Public License for more details.

# You should have received a copy of the GNU Affero General Public License
# along with this program.  If not, see <http://www.gnu.org/licenses/>.

from twisted.application import service, internet
from twisted.internet import protocol, reactor, task
from twisted.protocols import basic


IS_BUSY = False
# RENDERING_PROCESS_TIMEOUT = 60   # waits 1 minute by default
                                   # though it can be signaled to render
                                   # when a new job is in if it is not busy

IS_LOOP_STARTED = False

class renderProtocol( basic.LineReceiver ):
    """ Creates the loop that checks every once in a while
    when to look for jobs. And renders the actual townguide map.
    """

    # several loops:
    # l => rendering loop
    # TODO: download_loop maybe?
    l = None
    
    # sendLine activates the function that will render the job
    # maybe a feature could be to force the rendering of a job 
    def __init__(self):
        print 'disrendd Daemon started!!!'
        global IS_LOOP_STARTED
        global RENDERING_PROCESS_TIMEOUT
        RENDERING_PROCESS_TIMEOUT = 5
        if not renderProtocol.l:
            renderProtocol.l = task.LoopingCall(self.renderJobs)
            self.startRenderingLoop()
        else:
            print "The rendering loop has already been started"
            
    def startRenderingLoop(self):
        """ Starts the loop that checks for new rendering jobs from
        the database
        """
        print "STARTING THE RENDERING LOOP"
        global IS_LOOP_STARTED
        if not IS_LOOP_STARTED:
            renderProtocol.l.start(RENDERING_PROCESS_TIMEOUT)
            IS_LOOP_STARTED = True
        else:
            print "The rendering loop has already been started"

    def stopRenderingLoop(self):
        """Stops the rendering main loop
        """
        global IS_LOOP_STARTED
        if IS_LOOP_STARTED:
            print 'STOPPING THE RENDERING LOOP'
            renderProtocol.l.stop()
            IS_LOOP_STARTED = False
        else:
            print "THE RENDERING LOOP IS NOT ACTIVE RIGHT NOW"
        
    def renderJobs(self):
        """ Fetches the oldest rendering jobs from the database
        that have not been rendered (still status => new )and renders them with townguide. 
        """
        # if there are jobs waiting...
        # while WaitingJob.objects.count() <= 0:
        global IS_LOOP_STARTED

        IS_BUSY = True
        print "renderJobs...."
        # RENDER WITH TOWNGUIDE WITH DEFAULT STYLE
        #reactor.callInThread(renderer.renderWithTownguide,
        #                     waiting_job,
        #                     settings.TOWNGUIDE_DEFAULT_OSM_XML_STYLE )
        IS_BUSY = False



    def lineReceived(self, line):
        """ This function passes the parameters to the Daemon
        through a telnet session.
        """
        if hasattr(self, 'handle_' + line):
            getattr(self, 'handle_' + line)()
        else:
            self.sendLine(self.debug_daemon(line))

    def handle_quit(self):
        self.transport.loseConnection()

    def debug_daemon(self, option):
        """ By connecting to the port 2323 with telnet
        we can debug the daemon a la memcached.
        Current options are:
        - `.busy` : True if it is rendering, and False if it is not
        - `.render job %d`: Forcefully renders the job with that id
        - `.timeout %d`: Changes the default time for waiting before rendering jobs
        - `.startrendering`: Forces the daemon to render the jobs without waiting
        - `.renderlatest`: Forces the daemon to render the latest waiting_job
        - `.renderfailed`: Forces the daemon to render the failed jobs
        """
        import re

        print "Hi, this is disrendd"
        if re.search('busy?', option):
            return str(IS_BUSY)
        
        elif re.match('\.timeout(?P<timeout> .*)', option):
            m = re.match('\.timeout(?P<timeout> .*)', option)
            global RENDERING_PROCESS_TIMEOUT
            before = RENDERING_PROCESS_TIMEOUT
            RENDERING_PROCESS_TIMEOUT = int(m.groupdict()['timeout'])
            return "old timeout was: %d. timeout is now %d . \nRestart the loop to apply changes (.stop then .start)" % (before, RENDERING_PROCESS_TIMEOUT)

        elif re.match('\.renderlatest', option):
            self.renderLatest()
            return "Rendering the latest job"

        elif re.match('\.renderfailed', option):
            self.renderFailed()
            return "Rendering the latest failed jobs"

        elif re.match('\.start', option):
            self.startRenderingLoop()
            return "Started Rendering Loop"

        elif re.match('\.stop', option):
            self.stopRenderingLoop()
            return "Stopped Rendering Loop"
        
        else: 
            return 'No such option...'
        
# --------------------------------------------------------------
class renderFactory(protocol.ServerFactory):
    protocol = renderProtocol
    protocol()                          # start the service with twistd

class renderService(internet.TCPServer):
    def __init__(self):
        internet.TCPServer.__init__(self, 2323, renderFactory())
