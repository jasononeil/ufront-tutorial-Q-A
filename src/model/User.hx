package model;
import sys.db.Types;

/** 
Model for our users.  
*/
class User extends sys.db.Object 
{	
	/** The unique ID of this model */
	public var id:SUId;
	
	/** username used for logging in */
	public var username:SString<40>;
	
	/** password used for logging in, usually this would be MD5 encrypted. 
    Unfortunately I'm on a flight with no internet and I can't see the 
    best way to do this at the moment :) */
	public var password:SString<255>;
	
	/** Any extra text content (HTML) to be included in this question */
	public var email:SString<255>;
	
	/** The date this question was posted */
	public var registrationDate:SDateTime;
	
	// Each SPOD needs its own manager.  This line creates the Manager for this SPOD.
	static var manager = new sys.db.Manager<User>(User);
}