<?php

namespace Ianwfoster\objectoriented;

require_once(dirname(__DIR__, 2) . "/vendor/autoload.php");

use Ramsey\Uuid\Uuid;
/**
 * This is a class about an Author
 *
 * This is a class will capsule and sanitise with a mutator/setter and accessor/getter.
 * This will document all states variables in the class.This will also document the construcor method.
 *
 * @author Ian W Foster <ifoster2@cnm.edu>
 *
 **/
class Author  {
	use ValidateUuid;
	/**
	 * id for this Author; this is the primary key
	 * @var Uuid $AuthorId
	 **/
	private $AuthorId;
	/**
	 * at handle for this Author; this is a unique index
	 * @var string $AuthorAvatarUrl
	 **/
	private $AuthorAvatarUrl;
	/**
	 * token handed out to verify that the Author is valid and not malicious.
	 *v@var $AuthorActivationToken
	 **/
	private $AuthorActivationToken;
	/**
	 * email for this Author; this is a unique index
	 * @var string $AuthorEmail
	 **/
	private $AuthorEmail;
	/**
	 * hash for Author password
	 * @var $AuthorHash
	 **/
	private $AuthorHash;
	/**
	 * Name for this Author
	 * @var string $AuthorName
	 **/
	private $AuthorName;
	/**
	 * salt for Author password
	 *
	 * @var $AuthorSalt
	 */
	private $AuthorSalt;

	/**
	 * accessor method for Author id
	 *
	 * @return Uuid value of Author id (or null if new Author)
	 **/
	public function getAuthorId(): Uuid {
		return ($this->AuthorId);
	}
	/**
	 * mutator method for Author id
	 *
	 * @param  Uuid| string $newAuthorId value of new Author id
	 * @throws \RangeException if $newAuthorId is not positive
	 * @throws \TypeError if the Author Id is not
	 **/
	public function setAuthorId( $newAuthorId): void {
		try {
			$uuid = self::validateUuid($newAuthorId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		// convert and store the Author id
		$this->AuthorId = $uuid;
	}
	/**
	 * accessor method for account activation token
	 *
	 * @return string value of the activation token
	 */
	public function getAuthorActivationToken() : ?string {
		return ($this->AuthorActivationToken);
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
			$this->AuthorActivationToken = null;
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
		$this->AuthorActivationToken = $newAuthorActivationToken;
	}
	/**
	 * accessor method for at handle
	 *
	 * @return string value of at handle
	 **/
	public function getAuthorAvatarUrl(): string {
		return ($this->AuthorAvatarUrl);
	}
	/**
	 * mutator method for at handle
	 *
	 * @param string $newAuthorAvatarUrl new value of at handle
	 * @throws \InvalidArgumentException if $newAvatarUrl is not a string or insecure
	 * @throws \RangeException if $newAvatarUrl is > 32 characters
	 * @throws \TypeError if $newAvatarUrl is not a string
	 **/
	public function setAuthorAvatarUrl(string $newAuthorAvatarUrl) : void {
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
		$this->AuthorAvatarUrl = $newAuthorAvatarUrl;
	}
	/**
	 * accessor method for email
	 *
	 * @return string value of email
	 **/
	public function getAuthorEmail(): string {
		return $this->AuthorEmail;
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
		$this->AuthorEmail = $newAuthorEmail;
	}
	/**
	 * accessor method for AuthorHash
	 *
	 * @return string value of hash
	 */
	public function getAuthorHash(): string {
		return $this->AuthorHash;
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
		$this->AuthorHash = $newAuthorHash;
	}
	/**
	 * accessor method for Name
	 *
	 * @return string value of Name or null
	 **/
	public function getAuthorName(): ?string {
		return ($this->AuthorName);
	}
	/**
	 * mutator method for Name
	 *
	 * @param string $newAuthorName new value of Name
	 * @throws \InvalidArgumentException if $newName is not a string or insecure
	 * @throws \RangeException if $newName is > 32 characters
	 * @throws \TypeError if $newName is not a string
	 **/
	public function setAuthorName(?string $newAuthorName): void {
		//if $AuthorName is null return it right away
		if($newAuthorName === null) {
			$this->AuthorName = null;
			return;
		}
		// verify the Name is secure
		$newAuthorName = trim($newAuthorName);
		$newAuthorName = filter_var($newAuthorName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newAuthorName) === true) {
			throw(new \InvalidArgumentException("Author Name is empty or insecure"));
		}
		// verify the Name will fit in the database
		if(strlen($newAuthorName) > 32) {
			throw(new \RangeException("Author Name is too large"));
		}
		// store the Name
		$this->AuthorName = $newAuthorName;
	}
}

?>