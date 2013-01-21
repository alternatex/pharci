PHARCI := ~/.
JADE = $(shell find . -type f -print | grep ' ' | tr ' ' '?')
HTML = $(JADE:.jade=.html)
space := $(empty) $(empty)

# $(call space-to-question,file-name)
space-to-question = $(subst $(space),?,$1)

# $(call question-to-space,file-name)
question-to-space = $(subst ?,$(space),$1)

# $(call wildcard-spaces,file-name)
wildcard-spaces = $(wildcard $(call space-to-question,$1))

# $(call file-exists
file-exists = $(strip                                       \
				 $(if $1,,$(warning $1 has no value))       \
				 $(call wildcard-spaces,$1))

all: $(HTML)

$(call space-to-question,foo bar): $(call space-to-question,bar baz)
	touch "$(call question-to-space,$@)"

$(call space-to-question,%.html): $(call space-to-question,%.jade)
	echo "test" >> "$(shell echo '$@' | tr '?' ' ')"
	php "$(HOME)/.pharci/src/Pharci/pharci-make.php" "$(shell echo \"$@\" | tr '?' ' ')"

%.htmlx: %.jade
	echo "test" >> "$(shell echo '$@' | tr '?' ' ')"
	php "/Users/bazinga/.pharci/src/Pharci/pharci-make.php" "$@"	

pharci.phar: %.jade %.html %.php %.json %.js %.css %.ico %.png 
	echo "test" >> "/Users/bazinga/Desktop/pharci.phar"

%.html: %.jade
	echo "test" >> "$@"
	php "/Users/bazinga/.pharci/src/Pharci/pharci-make.php" "$@"	

%.jade:
	echo "test" >> "$@"
	php "/Users/bazinga/.pharci/src/Pharci/pharci-make.php" "$@"	

%.php:
	echo "test" >> "$@"
	php "/Users/bazinga/.pharci/src/Pharci/pharci-make.php" "$@"	

%.json:
	echo "test" >> "$@"
	php "/Users/bazinga/.pharci/src/Pharci/pharci-make.php" "$@"	

%.js:
	echo "test" >> "$@"
	php "/Users/bazinga/.pharci/src/Pharci/pharci-make.php" "$@"	

%.css:
	echo "test" >> "$@"
	php "/Users/bazinga/.pharci/src/Pharci/pharci-make.php" "$@"	

%.ico:
	echo "test" >> "$@"
	php "/Users/bazinga/.pharci/src/Pharci/pharci-make.php" "$@"	

%.png:
	echo "test" >> "$@"
	php "/Users/bazinga/.pharci/src/Pharci/pharci-make.php" "$@"	

clean:
	rm -f $(HTML)

.PHONY: clean