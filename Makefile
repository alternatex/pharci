PHARCI := ~/.
JADE = $(shell find . -type f -print | grep ' ' | tr ' ' '?')
HTML = $(JADE:.jade=.html)
space := $(empty) $(empty)

$(shell find . -type f -print | grep ' ' | tr ' ' '?')

find . -type f -print | grep 'zsh'

find . -type f -print | grep ' ' | tr ' ' '_'

find . -exec grep -n ' ' /dev/null {} \;

sed 's/[:space:]+/,/g'


echo 'Firstname LastName; 123-4567; Job Title
    Firstname LastName;   123-4567;      Job Title
Firstname LastName;      123-4567; Job Title' | sed 's/^[[:space:]]*//; s/;[[:space:]]*/;/g'

echo "sha; alal; lala lala " | sed 's/^ *//; s/; */;/g'

echo "sha; alal; lala lala " | sed 's/[:blank:]+/a/g'

echo "sha; alal; lala lala " | sed 's/^ *//; s/m */m/g'

echo 'shalala; alal; alal; alal alal ' | sed 's/^[[:space:]]*/ s/[[:space:]]*/g'
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

$(call file-exists,%._): %
	touch "nope"

$(call space-to-question,%.html): %.jade %.js
    echo "test" >> "$(shell echo $@ | tr '?' ' ')"
    php "$(HOME)/.pharci/src/Pharci/pharci-make.php" "$(shell echo $@ | tr '?' ' ')"

%.html: %.jade
	echo "test" >> "$@"
	php "/Users/bazinga/.pharci/src/Pharci/pharci-make.php" "$@"	

pharci.phar: %.jade %.html %.php %.json %.js %.css %.ico %.png 
	echo "test" >> "/Users/bazinga/Desktop/pharci.phar"

clean:
	rm -f $(HTML)

.PHONY: clean