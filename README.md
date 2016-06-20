Medialib.PropTypes
==================

Validate the properties passed to your constructor with class annotation. Can be used in any Flow Framework project. 
Your constructor must support a single variable and this variable should be an array. You can also enfore default values.

Validation and default value enforcement are done with AOP. 

**This package require Flow 2.3, not compatibile with Flow 3.0 currently**

**This is a preliminary realease, not considered stable and complet, API should change, and performance must be improved**

How to use it ?
---------------

    use Medialib\PropTypes\Annotations as Props;
    
    /**
     * EmitMessageOptions
     *
     * @api
     *
     * @Props\Types(
     *    subject = "string.isRequired",
     *    payload = "array",
     *    unique = "bool",
     *    connection = "string"
     * )
     *
     * @Props\Defaults(
     *    connection = "default"
     * )
     */
    class EmitMessageOptions
    {
        /**
         * @param array $options
         */
        public function __construct(array $options)
        {
            $this->subject = $options['subject'];
            $this->payload = $options['payload'];
            $this->unique = $options['unique'];
            $this->connection = $options['connection'];
        }
    }


Supported types
---------------

- [x] any
- [x] array
- [x] bool
- [x] func
- [x] number
- [x] object
- [x] string

Supported options
-----------------

- [x] isRequired

Acknowledgments
---------------

Development sponsored by [ttree ltd - neos solution provider](http://ttree.ch) and [medialib.tv](http://medialib.tv).

We try our best to craft this package with a lots of love, we are open to sponsoring, support request, ... just contact us.

License
-------

Licensed under MIT, see [LICENSE](LICENSE)
