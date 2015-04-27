<?php
namespace common\base;
use stak\Autoload;

/**
 * Provides a way for a function to provide more detail than a simple boolean response. As a
 * parameter, it should be passed-by-reference so it doesn't interfere with already existing return
 * statements.
 * @package common\base
 */
class Response {
    //Message types
    const TYPE_ALL = -1;
    const TYPE_ERROR = 0;
    const TYPE_NOTICE = 1;
    const TYPE_DEBUG = 2;

    /**
     * Sets the passed response parameter to an instance of a Response if it's not already set.
     * The passed function name is optionally used to identify a stacktrace in the debug scope.
     * @param Response $response
     * @param string $fnName
     */
    public static function getInstance(Response &$response = null, $fnName = null) {
        if (is_null($response))
            $response = new Response();

		$response->addDebug("Hi, I'm " . $fnName);
    }


    //Class variables
    private $messages;
    private $messageTypes;
    private $messageIndex;

    /**
     * Creates an empty response
     */
    public function __construct() {
        $this->messageIndex = 0;
    }

    /**
     * Checks if the any of the responses are errors. If so, the response is deemed a failure and
     * this function will return true.
     * @return bool
     */
    public function hasFailed() {
        return !is_array($this->messageTypes)
                && !is_array($this->messageTypes[self::TYPE_ERROR])
                && count($this->messageTypes[self::TYPE_ERROR]) > 0;
    }

    /**
     * Gets all error messages from the response. Returns an empty array if none exist. Be sure
	 * to sanitize when printing HTML!
     * @return string[]
     */
    public function getErrors() {
        return $this->getMessages(self::TYPE_ERROR);
    }

    /**
     * Gets all notice messages from the response. Returns an empty array if none exist. Be sure
	 * to sanitize when printing HTML!
     * @return string[]
     */
    public function getNotices() {
        return $this->getMessages(self::TYPE_NOTICE);
    }

    /**
     * Gets all debug messages from the response. Returns an empty array if none exist. Be sure
	 * to sanitize when printing HTML!
     * @return string[]
     */
    public function getDebugs() {
        return $this->getMessages(self::TYPE_DEBUG);
    }

    /**
     * Gets all messages from the response. Returns an empty array if none exist. Be sure to
	 * sanitize when printing HTML!
     * @return string[]
     */
    public function getAllMessages() {
        return $this->getMessages(self::TYPE_ALL);
    }

    /**
     * Gets the messages in the specified category. Returns an empty array if none exist in that
     * category.
     * @param int $type
     * @return string[]
     */
    private function getMessages($type) {
        if ($type == self::TYPE_ALL) {
            if (!is_array($this->messages))
                return array();
            else
                return $this->messages;
        }

        if (!is_array($this->messageTypes)
                || !is_array($this->messageTypes[$type]))
            return array();

        $messages = [];
        foreach ($this->messageTypes[$type] as $messageIndex)
            $messages[] = $this->messages[$messageIndex];

        return $messages;
    }

    /**
     * Adds an error message to the response
     * @param string $error
     */
    public function addError($error) {
        $this->add(self::TYPE_ERROR, $error);
    }

    /**
     * Adds a notice message to the response
     * @param string $notice
     */
    public function addNotice($notice) {
        $this->add(self::TYPE_NOTICE, $notice);
    }

    /**
     * Adds a debug message to the response
     * @param string $debug
     */
    public function addDebug($debug) {
		if (Autoload::getInjector()->getInstance(BaseSettings::class)->enableDebug())
        	$this->add(self::TYPE_DEBUG, $debug);
    }

    /**
     * Adds a message to the specified message type.
     * @param int $type
     * @param string $message
     */
    private function add($type, $message) {
        if (!is_array($this->messages))
            $this->messages = [];
        if (!is_array($this->messageTypes))
            $this->messageTypes = [];
        if (!isset($this->messageTypes[$type]) || !is_array($this->messageTypes[$type]))
            $this->messageTypes[$type] = [];

        $this->messages[$this->messageIndex] = $message;
        $this->messageTypes[$type][] = $this->messageIndex;
        $this->messageIndex++;
    }
}
