<?php
namespace Ianwfoster\ObjectOriented;
require_once("autoload.php");
require_once(dirname(__DIR__, 1) . "/vendor/autoload.php");

use Ramsey\Uuid\Uuid;


/**
 * id for this Author; this is the primary key
 * @var Uuid $AuthorId
 **/

/**
 * This is a class about an Author
 *
 * This is a class that will capsulise and sanitise with a mutator/setter and accessor/getter.
 * This will document all states variables in the class.This will also document the constructor method.
 *
 * @author Ian W Foster <ifoster2@cnm.edu>
 * @version o.o.1
 **/
class Author implements \JsonSerializable {
	use ValidateUuid;
	/**
	 * id for this Author; this is the primary key
	 * @var Uuid $authorId
	 **/
	private $authorId;
	/**
	 * author id that is this Author; this is a unique index
	 * @var string $authorAvatarUrl
	 **/
	private $authorAvatarUrl;
	/**
	 * token handed out to verify that the Author is valid and not malicious.
	 *v@var $authorActivationToken
	 **/
	private $authorActivationToken;
	/**
	 * email for this Author; this is a unique index
	 * @var string $authorEmail
	 **/
	private $authorEmail;
	/**
	 * hash for Author password
	 * @var $authorHash
	 **/
	private $authorHash;
	/**
	 * Name for this Author
	 * @var string $authorUserName
	 **/
	private $authorUserName;

	/**
	 * constructor for  this author.
	 *
	 * @param string $newAuthorId string containing newAuthorId
	 * @param string|null $newAuthorAvatarUrl
	 * @param string|null $authorActivationToken
	 * @param string $newAuthorEmail string containing email
	 * @param string $newAuthorHash string containg password hash
	 * @param string $newAuthorUserName string containing user name
	 */
	public function __construct($newAuthorId, ?string $newAuthorAvatarUrl, ?string $authorActivationToken, ?string $newAuthorEmail, ?string $newAuthorHash, ?string $newAuthorUserName) {
		try {
			$this->setAuthorId($newAuthorId);
			$this->setauthorAvatarUrl($newAuthorAvatarUrl);
			$this->setAuthorActivationToken($authorActivationToken);
			$this->setAuthorEmail($newAuthorEmail);
			$this->setAuthorHash($newAuthorHash);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			//determine what type was thrown
			$exceptionType = get_class(exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}


	/**
	 * accessor method for author id
	 *
	 * @return int value of author id (or null if new Author)
	 **/
	public function getAuthorId(): Uuid {
		return ($this->authorId);
	}

	/**
	 * mutator method for author id
	 *
	 * @param Uuid | string $newAuthorId
	 * @param \ RangeException if $newAuthorId is not a positive
	 * @throws \TypeError if $newAuthorId is not a Uuid
	 **/
	public function setAuthorId($newAuthorId): void {
		try {
			$uuid = self::validateUuid($newAuthorId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw (new $exceptionType($exception->getMessage(), 0, $exception));
		}
		//convert and store this author id
		$this->authorId = $uuid;
	}

	/**
	 * accessor method for author avatar url
	 *
	 * @return int value of author avatar url (or null if new Author)
	 **/
	public function getAuthorAvatarUrl(): Uuid {
		return ($this->authorAvatarUrl);
	}

	/**
	 * mutator method for author avatar url
	 *
	 * @param Uuid | string $newauthorAvatarUrl
	 * @param \ RangeException if $newauthorAvatarUrl is not a positive
	 * @throws \TypeError if $newAuthorId is not a Uuid
	 **/
	/*public function setAuthorAvatarUrl( $newAuthorAvatarUrl): void {
		try {
			$uuid = self::validateUuid($newAuthorAvatarUrl);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw (new $exceptionType($exception->getMessage(), 0, $exception));
		}
		//convert and store this author id
		$this->authorAvatarUrl = $uuid;
	}*/


	/**
	 * accessor method for account activation token
	 *
	 * @return string value of the activation token
	 */
	public function getAuthorActivationToken(): ?string {
		return ($this->authorActivationToken());
	}

	/**
	 * mutator method for account activation token
	 *
	 * @param string $newAuthorActivationToken
	 * @throws \InvalidArgumentException  if the token is not a string or insecure
	 * @throws \RangeException if the token is not exactly 32 characters
	 * @throws \TypeError if the activation token is not a string
	 */
	public function setAuthorActivationToken(?string $newAuthorActivationToken): void {
		if($newAuthorActivationToken === null) {
			$this->authorActivationToken = null;
			return;
		}
		$newAuthorActivationToken = strtolower(trim($newAuthorActivationToken));
		if(ctype_xdigit($newAuthorActivationToken) === false) {
			throw(new\RangeException("user activation is not valid"));
		}
		//make sure user activation token is only 32 characters
		if(strlen($newAuthorActivationToken) !== 32) {
			throw(new\RangeException("user activation token has to be 32"));
		}
		$this->authorActivationToken = $newAuthorActivationToken;
	}


	/**
	 * mutator method for at handle
	 *
	 * @param string $newAuthorAvatarUrl new value of at handle
	 * @throws \InvalidArgumentException if $newAvatarUrl is not a string or insecure
	 * @throws \RangeException if $newAvatarUrl is > 32 characters
	 * @throws \TypeError if $newAvatarUrl is not a string
	 **/
	public function setAuthorAvatarUrl(string $newAuthorAvatarUrl): void {
		// verify the at handle is secure
		$newAuthorAvatarUrl = trim($newAuthorAvatarUrl);
		$newAuthorAvatarUrl = filter_var($newAuthorAvatarUrl, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newAuthorAvatarUrl) === true) {
			throw(new \InvalidArgumentException("Author at handle is empty or insecure"));
		}
		// verify the at handle will fit in the database
		if(strlen($newAuthorAvatarUrl) > 32) {
			throw(new \RangeException("Author at handle is too large"));
		}
		// store the at handle
		$this->authorAvatarUrl = $newAuthorAvatarUrl;
	}

	/**
	 * accessor method for email
	 *
	 * @return string value of email
	 **/
	public function getAuthorEmail(): string {
		return $this->authorEmail;
	}

	/**
	 * mutator method for email
	 *
	 * @param string $newAuthorEmail new value of email
	 * @throws \InvalidArgumentException if $newEmail is not a valid email or insecure
	 * @throws \RangeException if $newEmail is > 128 characters
	 * @throws \TypeError if $newEmail is not a string
	 **/
	public function setAuthorEmail(string $newAuthorEmail): void {
		// verify the email is secure
		$newAuthorEmail = trim($newAuthorEmail);
		$newAuthorEmail = filter_var($newAuthorEmail, FILTER_VALIDATE_EMAIL);
		if(empty($newAuthorEmail) === true) {
			throw(new \InvalidArgumentException("Author email is empty or insecure"));
		}
		// verify the email will fit in the database
		if(strlen($newAuthorEmail) > 128) {
			throw(new \RangeException("Author email is too large"));
		}
		// store the email
		$this->authorEmail = $newAuthorEmail;
	}

	/**
	 * accessor method for AuthorHash
	 *
	 * @return string value of hash
	 */
	public function getAuthorHash(): string {
		return $this->authorHash;
	}

	/**
	 * mutator method for Author hash password
	 *
	 * @param string $newAuthorHash
	 * @throws \InvalidArgumentException if the hash is not secure
	 * @throws \RangeException if the hash is not 128 characters
	 * @throws \TypeError if Author hash is not a string
	 */
	public function setAuthorHash(string $newAuthorHash): void {
		//enforce that the hash is properly formatted
		$newAuthorHash = trim($newAuthorHash);
		if(empty($newAuthorHash) === true) {
			throw(new \InvalidArgumentException("Author password hash empty or insecure"));
		}
		//enforce the hash is really an Argon hash
		$AuthorHashInfo = password_get_info($newAuthorHash);
		if($AuthorHashInfo["algoName"] !== "argon2i") {
			throw(new \InvalidArgumentException("Author hash is not a valid hash"));
		}
		//enforce that the hash is exactly 97 characters.
		if(strlen($newAuthorHash) !== 97) {
			throw(new \RangeException("Author hash must be 97 characters"));
		}
		//store the hash
		$this->authorHash = $newAuthorHash;
	}

	/**
	 * accessor method for Name
	 *
	 * @return string value of Name or null
	 **/
	public function getauthorUserName() {
		return ($this->authorUserName);
	}

	/**
	 * mutator method for Name
	 *
	 * @param string $newauthorUserName new value of Name
	 * @throws \InvalidArgumentException if $newName is not a string or insecure
	 * @throws \RangeException if $newName is > 32 characters
	 * @throws \TypeError if $newName is not a string
	 **/
	public function setauthorUserName(?string $newauthorUserName): void {
		//if $authorUserName is null return it right away
		if($newauthorUserName === null) {
			$this->authorUserName = null;
			return;
		}
		// verify the Name is secure
		$newauthorUserName = trim($newauthorUserName);
		$newauthorUserName = filter_var($newauthorUserName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newauthorUserName) === true) {
			throw(new \InvalidArgumentException("Author Name is empty or insecure"));
		}
		// verify the Name will fit in the database
		if(strlen($newauthorUserName) > 32) {
			throw(new \RangeException("Author Name is too large"));
		}
		// store the Name
		$this->authorUserName = $newauthorUserName;
	}


	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/
	public function jsonSerialize(): array {
		$fields = get_object_vars($this);

		$fields["authorId"] = $this->authorId->toString();

		return ($fields);
	}

}




