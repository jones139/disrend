#!/usr/bin/env python

# NAME: disrendd
# DESC: Daemon process for a distributed map rendering system.
#       Runs on rendering computers to request jobs from the front end server
#       and render them.
# HIST:
#       22jun2011  GJ  Orignal version based on Waldemar's townguide-daemon.
#

# First, set up the environment
import os

# The daemon runs as a Twisted application
from twisted.application import service
import daemon

# Changing the default logging support from the daemon

application = service.Application("disrendd")
renderService = daemon.renderService()
renderService.setServiceParent(application)

print 'Starting the daemon...'
print """Connect to its process with `telnet localhost 2323` and enter one of the following options:
.start            - Starts Rendering Loop
.stop             - Stops Rendering Loop
.render           - Render on a first in, first served basis
.renderlatest     - Render the latest job added to the queue
.renderfailed     - Render the latest job added to the queue
.timeout 15       - Changes the rendering time out to 15 seconds
"""
