
 <form action="{{ url('/') }}/tokenvalidation" method="POST" class="user">
                            @csrf
                            
                           <input type="text" name="token" value="eyJzdHVkZW50X2lkIjoxNjUyMiwic2Nob29sX2NvZGUiOiJMTVNLRUwiLCJzdHVkZW50X25hbWUiOiJHSVJJU0ggVEhBS1VSIiwiZW1haWwiOiJLRUwyMzY5XzIxQGxtcy5vcmcuaW4iLCJwaG9uZSI6Ijk4MTY0NDEzNDQiLCJzZWN0aW9uIjoiQSIsImNsYXNzIjoiSUlJIiwiYmlsbGluZ19hZGRyZXNzIjoiVlBPIFBBTkFSU0EgVEVIIEFVVCBESVNUVE1BTkRJIEhQIiwiYmlsbGluZ19jaXR5IjoiUEFOQVJTQSIsImJpbGxpbmdfc3RhdGUiOiJIUCIsImJpbGxpbmdfZGlzdHJpY3QiOiIiLCJiaWxsaW5nX3BpbmNvZGUiOiIxNzUwMDUiLCJzaGlwcGluZ19hZGRyZXNzIjoiVlBPIFBBTkFSU0EgVEVIIEFVVCBESVNUVE1BTkRJIEhQIiwic2hpcHBpbmdfcGluY29kZSI6IjE3NTAwNSIsInNoaXBwaW5nX2NpdHkiOiJQQU5BUlNBIiwic2hpcHBpbmdfc3RhdGUiOiJIUCIsInNoaXBwaW5nX2Rpc3RyaWN0IjoiIiwiZmF0aGVyX25hbWUiOiJWSU5PRCBLVU1BUiIsInBhc3N3b3JkIjoiTWprd01USXdNVGM9In0=">
                         <button class="btn btn-primary d-grid w-100" type="submit">Test Button</button>
                          </form> 