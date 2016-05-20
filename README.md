# Welcome to parseConfig
This is a sample PHP project for a developer position. Please see my other sample repositories as well!

[parseConfig()](#parseconfig)  
[Specification](#specification)  
[Example](#example-usage)  
[Testing](#testing)  
[TODO](#todo)  
[Author](#author)  

## parseConfig()
`parseConfig()` parses a configuration file which may contain comments and configuration variable key/pairs and spits out an associative array of the variables which it set. This parsing is done line by line.

Lines beginning with the '#' character are treated as comments and ignored.
Lines containing the '=' character are treated as configuration variable key/value pairs and we attempt to parse them as such. If they fail either the key or value regex they are ignored.
All other lines are ignored.
If a key is given more than once in the configuration file, the value in the last valid definition will be used.

Configuration variables are whitelisted in the $configspec associative array. These names are case sensitive.  Each variable in the specification has a type and an optional regex which the value must match. If no regex is given, we fall back to a default regex per-type (see below).

There are three supported types:
 - string - any string of text. default regex is `/^[a-zA-Z0-9_.-]+$/` (Note that spaces are not included.)
 - number - any ints or floats. default regex is `/^\d*\.?\d+$/`
 - boolean - yes/no, on/off, true/false. default regex is `/^(yes|no|true|false|on|off)$/`

## Example usage:
See `test.php` for a demonstration, or this short snippet below:

    require_once('parseconfig.php');

    $configspec = array(
      "user" => array(
        "type" => 'string',
        "regex" => '[a-z]+',
      ),
      "server_id" => array(
        "type" => 'number',
      ),
      "verbose" => array(
        "type" => 'boolean',
      ),
    );

    $config = parseConfig($configspec, $configfile);

    # config variables are now available in $config associative array with their names as keys.
    # $config[user]
    # $config[server_id]
    # $config[verbose]
    # etc

    if ($config[verbose]) {
        print "User $config[user] on server_id $config[server_id]\n";
    }

Given the sample configuration file, below, the above code would output

    User user on server_id 55331

## Testing
`php parseconfig_test.php` will run a series of unit tests using `test.config`

    > php parseconfig_test.php
    
    Running parseconfig unit tests...
    boolean.yesno.yes: SUCCESS
    boolean.yesno.no: SUCCESS
    boolean.yesno.true: SUCCESS
    boolean.yesno.false: SUCCESS
    boolean.yesno.null: SUCCESS
    boolean.truefalse.yes: SUCCESS
    boolean.truefalse.no: SUCCESS
    boolean.truefalse.true: SUCCESS
    boolean.truefalse.false: SUCCESS
    boolean.truefalse.null: SUCCESS
    string.regex.letters.abcd: SUCCESS
    string.regex.letters.AbCd: SUCCESS
    string.regex.letters.1abc: SUCCESS
    string.regex.letters.abc_: SUCCESS
    number.100: SUCCESS
    number.one: SUCCESS
    number.5.5: SUCCESS
    number.0: SUCCESS
    number.0.0: SUCCESS
    uncommented: SUCCESS
    commented: SUCCESS
    spaces.none: SUCCESS
    spaces.left: SUCCESS
    spaces.right: SUCCESS
    spaces.leading: SUCCESS
    spaces.trailing: SUCCESS
    spaces.lots: SUCCESS
    spaces.between: SUCCESS


## Specification
Write some code that can parse a configuration file
following the specifications below. Follow your
own best practices and coding/design principles.

- Do not use existing "complete" configuration parsing
  libraries/functions, we want to see how you would write the code
  to do this.
- Use of core and stdlib functions/objects such as string
  manipulation, regular expressions, etc is ok.
- We should be able to get the values of the config parameters in
  code, via their name. How this is done specifically is up to you.
- Boolean-like config values (on/off, yes/no, true/false) should
  return real booleans: true/false.
- Numeric config values should return real numerics: integers,
  doubles, etc
- Ignore or error out on invalid config lines, your choice.
- Please include a short example usage of your code so we can see
  how you call it/etc.
- Push your work to a public github repository and send us the link.

#### Valid config file:

    # This is what a comment looks like, ignore it
    # All these config lines are valid
    host = test.com
    server_id=55331
    server_load_alarm=2.5
    user= user
    # comment can appear here as well
    verbose =true
    test_mode = on
    debug_mode = off
    log_file_path = /tmp/logfile.log
    send_notifications = yes

##TODO
Possible enhancements:
- option to warn if value doesn't match regex

## Author
Hey - I'm Brett. I like coding and solving problems. Questions?

brett.schellenberg@gmail.com
