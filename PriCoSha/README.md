
Project Proposal

Using the basic and advanced knowledge on MySQL and PHP, we've developed a web application called "PriCoSha". PriCoSha is a network service of social media sort that allows users to freely post content items and share them among groups of people. PriCoSha gives users somewhat more privacy than many content sharing sites by giving them more detailed control over who can see which content items they post and also give users the authority to accept, ignore or decline a tag when a tag request is sent from a tagger.

Users will be able to log in, post content items, where the user may choose any kind of content e.g. photos, video clips, announcements on events, etc., and view (some of) the content items posted by others (public content and content posted by people who have given them access via a 'friend' mechanism). Users will also be able to use additional features provided, including defriend, add comment, archive, and tagging a group. Detailed explanation of them is presented below.



===============================================================



Extra Features (total of 4)
•Defriend
	o A User may defriend another user by completing a form. When the form submits and runs succesfully, the user that you just defriended will be removed from your FriendGroup list and all the tags of that defriended user will also be removed.

•Add Comments
	o Users can add comments about a content that is accessible to them. Words and emoji are stored as data and comments are visible to all group members that are in that specific FriendGroup. 
	o This feature is necessary to share thoughts about the content among the members of the group.
	o Requires a new table 'Comment'

•Archive
	o When the user clicks the button archive on a content item, the corresponding item will be saved in the archive folder which can be found in the sidebar.
	o This feature is necessary since the contents that were posted long ago are difficult to retrieve unless it’s archived. Thus, this function allows the user to archive (“save for later”) the content so that they can access the content on their private account more easily.
	o Requires a new table 'Archive'
	
•Tagging a Group
	o Instead of tagging a person one by one, a user can tag a group of people at once. When tagging, all individuals in that group must agree to the tagging in order to make the tag visible. 
	o Requires a new table 'TagFriendGroup'


================================================================


Contributions

•Yewon Cho (yc2654)
- View public content
- Login
- View Shared content items and info about them
- Manage tags
- Post a content item
- Tag a content item
- *Defriend

•Jungho Kook (jk5541)
- Add friend
- *Tag as a group
- *Add comment


•EunSoo (Sally) Kim (ek2777)
- Proposed ideas for additional features
- Login
- *Archive
- README.md

*Extra feature(s)









