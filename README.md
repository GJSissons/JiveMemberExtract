# JiveMemberExtract
A PHP script to extract membership from a Jive Cloud Instance using the REST API

For JIVE cloud users, a frequently asked question is how to extract the JIVE membership list.

Working with a client implementing Jive, I came up against this same problem. In our case we wanted to generate statistics about our membership based on custom fields we had added to Jive. While the JIVE web interface is excellent for viewing membership, there is no mechanism to download your membership into a CSV file. Trying to generate metrics about how users answered questions in their profiles was tedious when we had a few users, but became pretty much impossible as our membership exceeded 1,000.

The only way to extract and analyze membership in a manner that scales (so far as I know) is to use the Jive REST API. 

Different JIVE users will have different needs - I just wanted to share an example as a starting point. 

This script is dumbed down considerably from the script we are actually using in production, but we are analyzing fields specific to our use of Jive. This sanitized version of the script shows how the problem is solved without sharing details specific to our implementation.

##Try it Live

If you want to quickly try this script against your own Jive instance, you can test it at this URL:

https://e42fb64d.servage-customer.net/jive_metrics/index.php

By the way - if you're like me I would never punch my URL and administrator credentials into a website. The script does not store your credentials but I completely respect people who decide not to trust this. (I wouldn't). I host this script nonetheless because people who I know find it convenient (as do I). The more responsible approach I acknowledge is to read on and host the same script yourself on your own web-server so you can be sure things are legit. 

##About the scripts

The simple solution involves two PHP scripts.

* index.php - Presents a screen requesting login credentials and the Jive site URL
* get_membership.php - The back-end script called by index.php that calls the Jive REST API with the credentials provided.



