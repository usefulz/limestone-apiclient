limestone-apiclient
===================

Limestone Rockware PHP API Client

* Set your API key from RW > Administrative > API
* Put this code on server whose IP is authorized to use the API

Instanciate the LSN object by using:

  $limestone = new LSN('YOUR_API_KEY');

Then you can access the API functions via:

  $limestone->bwgraph(...);
  $limestone->addticket(...);
  etc..
