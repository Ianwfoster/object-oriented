<?php
namespace Ianwfoster\ObjectOriented;
require_once("autoload.php");
require_once(dirname(__DIR__, 1) . "/vendor/autoload.php");

use Exception;
use InvalidArgumentException;
use JsonSerializable;
use Ramsey\Uuid\Uuid;
use RangeException;
use TypeError;


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
class Author implements JsonSerializable {
	use ValidateDate;
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
	private $Date;

	/**
	 * constructor for  this author.
	 *
	 * @param string $newAuthorId string containing newAuthorId
	 * @param string|null $newAuthorAvatarUrl
	 * @param string|null $newAuthorActivationToken
	 * @param string $newAuthorEmail string containing email
	 * @param string $newAuthorHash string containg password hash
	 * @param string $newAuthorUserName string containing user name
	 */
	public function __construct($newAuthorId, string $newAuthorAvatarUrl, ?string $newAuthorActivationToken, string $newAuthorEmail, string $newAuthorHash, ?string $newAuthorUserName) {
		try {
			$this->setAuthorId($newAuthorId);
			$this->setauthorAvatarUrl($newAuthorAvatarUrl);
			$this->setAuthorActivationToken($newAuthorActivationToken);
			$this->setAuthorEmail($newAuthorEmail);
			$this->setAuthorHash($newAuthorHash);
			$this->setAuthorUserName($newAuthorUserName);
		} catch(InvalidArgumentException | RangeException | Exception | TypeError $exception) {
			//determine what type was thrown
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}


	/**
	 * accessor method for author id
	 *
	 * @return Uuid value of author id (or null if new Author)
	 */
	public function getAuthorId(): Uuid {
		return ($this->authorId);
	}

	/**
	 * mutator method for author id
	 *
	 * @param Uuid | string $newAuthorId
	 * @param RangeException if $newAuthorId is not a positive
	 * @throws TypeError if $newAuthorId is not a Uuid
	 **/
	public function setAuthorId($newAuthorId): void {
		try {
			$uuid = self::validateUuid($newAuthorId);
		} catch(InvalidArgumentException | RangeException | Exception | TypeError $exception) {
			$exceptionType = get_class($exception);
			throw (new $exceptionType($exception->getMessage(), 0, $exception));
		}
		//convert and store this author id
		$this->authorId = $uuid;
	}

	/**
	 * accessor method for author avatar url
	 *
	 * @return string|null value of author avatar url (or null if new Author)
	 */
	public function getAuthorAvatarUrl(): ?string {
		return ($this->authorAvatarUrl);
	}

	/**
	 * mutator method for at handle
	 *
	 * @param string $newAuthorAvatarUrl new value of at handle
	 * @throws InvalidArgumentException if $newAvatarUrl is not a string or insecure
	 * @throws RangeException if $newAvatarUrl is > 32 characters
	 * @throws TypeError if $newAvatarUrl is not a string
	 **/
	public function setAuthorAvatarUrl(string $newAuthorAvatarUrl): void {
		// verify the at handle is secure
		$newAuthorAvatarUrl = trim($newAuthorAvatarUrl);
		$newAuthorAvatarUrl = filter_var($newAuthorAvatarUrl, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newAuthorAvatarUrl) === true) {
			throw(new InvalidArgumentException("Author at handle is empty or insecure"));
		}
		// verify the at handle will fit in the database
		if(strlen($newAuthorAvatarUrl) > 32) {
			throw(new RangeException("Author at handle is too large"));
		}
		// store the at handle
		$this->authorAvatarUrl = $newAuthorAvatarUrl;
	}

	/**
	 * accessor method for account activation token
	 *
	 * @return string value of the activation token
	 */
	public function getAuthorActivationToken(): ?string {
		return ($this->authorActivationToken);
	}

	/**
	 * mutator method for account activation token
	 *
	 * @param string $newAuthorActivationToken
	 * @throws InvalidArgumentException  if the token is not a string or insecure
	 * @throws RangeException if the token is not exactly 32 characters
	 * @throws TypeError if the activation token is not a string
	 */
	public function setAuthorActivationToken(?string $newAuthorActivationToken): void {
		if($newAuthorActivationToken === null) {
			$this->authorActivationToken = null;
			return;
		}

		//make sure user activation token is only 32 characters
		if(strlen($newAuthorActivationToken) !== 32) {
			throw(RangeException("user activation token has to be 32"));
		}
		$this->authorActivationToken = $newAuthorActivationToken;
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
	 * @throws InvalidArgumentException if $newEmail is not a valid email or insecure
	 * @throws RangeException if $newEmail is > 128 characters
	 * @throws TypeError if $newEmail is not a string
	 **/
	public function setAuthorEmail(string $newAuthorEmail): void {
		// verify the email is secure
		$newAuthorEmail = trim($newAuthorEmail);
		$newAuthorEmail = filter_var($newAuthorEmail, FILTER_VALIDATE_EMAIL);
		if(empty($newAuthorEmail) === true) {
			throw(new InvalidArgumentException("Author email is empty or insecure"));
		}
		// verify the email will fit in the database
		if(strlen($newAuthorEmail) > 128) {
			throw(new RangeException("Author email is too large"));
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
		return ($this->authorHash);
	}

	/**
	 * mutator method for author hash password
	 *
	 * @param string $newAuthorHash
	 * @throws InvalidArgumentException if the hash is not secure
	 * @throws RangeException if the hash is not 128 characters
	 * @throws TypeError if author hash is not a string
	 */
	public function setAuthorHash(string $newAuthorHash): void {
		//enforce that the hash is properly formatted
		$newAuthorHash = trim($newAuthorHash);
		$newAuthorHash = strtolower($newAuthorHash);
		if(empty($newAuthorHash) === true) {
			throw(new InvalidArgumentException("author password hash empty or insecure"));
		}
		//enforce that the hash is a string representation of a hexadecimal
		if(!ctype_xdigit($newAuthorHash)) {
			throw(new InvalidArgumentException("author password hash is empty or insecure"));
		}
		//enforce that the hash is exactly 97 characters.
		if(strlen($newAuthorHash) !== 97) {
			throw(new RangeException("author hash must be 97 characters"));
		}
		//store the hash
		$this->authorHash = $newAuthorHash;
	}

	/**
	 * inserts this author into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param $query
	 */
	public function insert(\PDO $pdo, $query, $Date): void {

		/// create query template
		$query = "INSERT INTO author(authorId,authorAvatarUrl, authorActivationToken, authorEmail, authorHash) VALUES(:authorId, :authorAvatar, :authorActivationToken, :authorEmail, authorHash)";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$parameters = ["authorId" => $this->authorId->getBytes(), "authorAvatarUrl" => $this->authorAvatarUrl->getBytes(), "authorEmail" => $this->authorEmail, "authorHash" => $this->authorHash];
		$statement->execute($parameters);
		}

	/**
	 * deletes this author from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function delete(\PDO $pdo) : void {

		// create query template
		$query = "DELETE FROM author WHERE authorId = :authorId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holder in the template
		$parameters = ["authorId" => $this->authorId->getBytes()];
		$statement->execute($parameters);
	}
		

		/**
		 * accessor method for Name
		 *
		 * @return string value of Name or null
		 **/
		public
		function getAuthorUserName(): string {
			return ($this->authorUserName);
		}

		/**
		 * mutator method for Name
		 *
		 * @param string|null $newAuthorUserName
		 */
		public
		function setAuthorUserName(?string $newAuthorUserName): void {
			//if $authorUserName is null return it right away
			if($newAuthorUserName === null) {
				$this->authorUserName = null;
				return;
			}
			// verify the Name is secure
			$newAuthorUserName = trim($newAuthorUserName);
			$newAuthorUserName = filter_var($newAuthorUserName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
			if(empty($newAuthorUserName) === true) {
				throw(new InvalidArgumentException("Author Name is empty or insecure"));
			}
			// verify the Name will fit in the database
			if(strlen($newAuthorUserName) > 32) {
				throw(new RangeException("Author Name is too large"));
			}
			// store the Name
			$this->authorUserName = $newAuthorUserName;
		}

	/**
	 * gets the author by authorId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param Uuid|string $authorId author id to search for
	 * @return author|null author found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when a variable are not the correct data type
	 **/
	public static function getAuthorByAuthorId(\PDO $pdo, $authorId, $newauthor) : ?author {
		// sanitize the authorId before searching
		try {
			$authorId = self::validateUuid($authorId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}

		//  query template for author
		$query = "SELECT authorId, authorAvatarUrl, authorActivationToken, authorEmail, authorHash FROM author WHERE authorId = :authorId";
		$statement = $pdo->prepare($query);

		// bind the author id to the place holder in the template
		$parameters = ["authorId" => $authorId->getBytes()];
		$statement->execute($parameters);

		// grab the author from mySQL
		try {
			$author = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$author = $newauthor($row["authorId"], $row["authorAvatar"], $row["authorActivationToken"], $row["authorEmail"], $row["authorHash"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($author);
	}


	/**
	 * get all authors by username
	 *
	 * @param \PDO $pdo PDO Connection object
	 * @param $authorUserName
	 * @return \SplFixedArray SplFixedArray of authors found or null if not found
	 */
	public static function getAuthorByUserName (\PDO $pdo, $authorUserName) : \SplFixedArray {
		$authorUserName = trim($authorUserName);
		$authorUserName = filter_var($authorUserName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($authorUserName) === true) {
			throw(new InvalidArgumentException("Author Name is empty or insecure"));
		}
		// verify the Name will fit in the database
		if(strlen($authorUserName) > 32) {
			throw(new RangeException("Author Name is too large"));
		}
		// create query temp.
		$query = "SELECT authorId, authorActivationToken, authorAvatarUrl, authorEmail, authorHash, authorUserName FROM author WHERE authorUserName = :authorUserName";
		$statement = $pdo->prepare($query);
		$parameters = ["authorUserName"=>$authorUserName];
		$statement->execute($parameters);
		//build an array of authors
		$authors = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row =$statement->fetch()) !== false) {
			try {
				$author = new Author($row["authorId"], $row["authorActivationToken"], $row["authorAvatarUrl"], $row["authorEmail"],
					$row["authorHash"], $row["authorUserName"]);
				$authors[$authors->key()] = $author;
				$authors->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw (new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($authors);
	}
	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/
	public function jsonSerialize() {
		$fields = get_object_vars($this);
		$fields["authorId"] = $this->authorId->toString();
		unset($fields["authorHash"]);
		return ($fields);
	}

	}





