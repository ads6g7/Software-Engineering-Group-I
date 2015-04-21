#################################################
# Makefile format
# target: dependencies
# <tab>	 Command to generate target
#################################################

# -----------------------------------------------
# Super useful shortcuts:
#   $@ matches the target;
#   $< matches the first dependent
#   $^ Matches all dependencies
# -----------------------------------------------

# -----------------------------------------------
# But first, some definitions.

# -----------------------------------------------
# Flag to replace gcc,  $(CC) = gcc
CC=gcc

# -----------------------------------------------
#
# CLEAN definition - git rid of compiled stuff
#below is how to format the clean command
#CLEAN= rm -rf *.o story
#below is how to format the clean command
#CLEANWIN = del /f /s *.o *.exe story
#
# -----------------------------------------------


# -----------------------------------------------
# TEST definition - write to file and cat file
#below is how to define a test command
#TEST= (./story | tee the_story.txt)

# -----------------------------------------------
# The standard default target is 'all'
# This target has no command, only a dependency.
# We will execute test   though, when it's built.
# -----------------------------------------------

#how to define some of the other parts of the file still using the story example
#all: story
#test: @$(TEST)
# -----------------------------------------------
# When you type 'make clean', you get rid of
# all of the *.o and the 'story' file.
# -----------------------------------------------

#clean:	$(CLEAN)
#cleanwin: $(CLEANWIN)

# -----------------------------------------------
# Now we bring in our dependencies.
# 'all' needs 'story'. What does story need?
# And how do we make it?
# -----------------------------------------------

#story: story.o \
#	scottgs.o \
#	$(CC) -o story $^


#pawprint.o -  where is your .c derived object file
# -----------------------------------------------
#story.o: story.c
#	$(CC) -c $^

# -----------------------------------------------
# Add an target of your object file, with your source as the dependency
#bpbkt7.o: sentences/bpbkt7.c
#		$(CC) -c $<
