SleepyPhp
=========

A basic but very functional, VERY adaptable php REST api.

Usage
=====

If the script is installed in /rest/

You would call the test function as such

http://www.example.com/rest/test/helloWorld/value1/derp

rest/{class name}/{function name}/{argument name}/{argument value}

You can add as many argument pairs as you desire, and they can be in any order.

Examine ../restClasses/test.php for an example on how to create additional scripts. Any script you add can automatically be used, you do not have to add then to any type of list or database, the script automatically figures what what you want to call and calls it.