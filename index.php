<html xmlns="http://www.w3.org/1999/xhtml">
<head runat="server">
    <title></title>
        <script src="../Scripts/jquery-1.4.1.js" type="text/javascript"></script>
</head>
<body>
    <form id="form1" runat="server">
    <div><br />Example A</div>
    <div id="searchresultsA"></div>
    <div><br />Example B</div>
    <div id="searchresultsB"></div>
    <div><br />Example C</div>
    <div id="searchresultsC"></div>
    <div><br />Example D</div>
    <div id="searchresultsD"></div>
    <div><br />Example E</div>
    <div id="searchresultsE"></div>

    <script type="text/javascript">
        /*
        SayHello        returns a string
        SayHelloJson    returns a string that is an object in JSON format
        SayHelloObject  returns an object

        [WebMethod]
        public string SayHello(string firstName, string lastName)
        {
            return "Hello " + firstName + " " + lastName;
        }

        [WebMethod]
        public string SayHelloJson(string firstName, string lastName)
        {
            var data = new { Greeting = "Hello", Name = firstName + " " + lastName };

            // We are using an anonymous object above, but we could use a typed one too (SayHello class is defined below)
            // SayHello data = new SayHello { Greeting = "Hello", Name = firstName + " " + lastName };

            System.Web.Script.Serialization.JavaScriptSerializer js = new System.Web.Script.Serialization.JavaScriptSerializer();

            return js.Serialize(data);
        }

        [WebMethod]
        public SayHello SayHelloObject(string firstName, string lastName)
        {
            SayHello o = new SayHello();
            o.Greeting = "Hello";
            o.Name = firstName + " " + lastName;

            return o;
        }

        public class SayHello
        {
            public string Greeting { get; set; }
            public string Name { get; set; }
        }
        */

        $(document).ready(function () {
            // SayHello returns a string we want to display.  Examples A, B and C show how you get the data in native
            // format (xml wrapped) as well as in JSON format.  Also how to send the parameters in form-encoded format,
            // JSON format and also JSON objects.  To get JSON back you need to send the params in JSON format.

            // Example A - call a function that returns a string.
            // Params are sent as form-encoded, data that comes back is text
            $.ajax({
                type: "POST",
                url: "MyWebService.asmx/SayHello",
                data: "firstName=Aidy&lastName=F", // the data in form-encoded format, ie as it would appear on a querystring
                //contentType: "application/x-www-form-urlencoded; charset=UTF-8", // if you are using form encoding, this is default so you don't need to supply it
                dataType: "text", // the data type we want back, so text.  The data will come wrapped in xml
                success: function (data) {
                    $("#searchresultsA").html(data); // show the string that was returned, this will be the data inside the xml wrapper
                }
            });

            // Example B - call a function that returns a string.
            // Params are sent in JSON format, data that comes back is JSON
            $.ajax({
                type: "POST",
                url: "MyWebService.asmx/SayHello",
                data: "{firstName:'Aidy', lastName:'F'}", // the data in JSON format.  Note it is *not* a JSON object, is is a literal string in JSON format
                contentType: "application/json; charset=utf-8", // we are sending in JSON format so we need to specify this
                dataType: "json", // the data type we want back.  The data will come back in JSON format
                success: function (data) {
                    $("#searchresultsB").html(data.d); // it's a quirk, but the JSON data comes back in a property called "d"; {"d":"Hello Aidy F"}
                }
            });

            // Example C - call a function that returns a string.
            // Params are sent as a JSON object, data that comes back is text
            $.ajax({
                type: "POST",
                url: "MyWebService.asmx/SayHello",
                data: { firstName: 'Aidy', lastName: 'F' }, // here we are specifing the data as a JSON object, not a string in JSON format
                        // this will be converted into a form encoded format by jQuery
                // even though data is a JSON object, jQuery will convert it to "firstName=Aidy&lastName=F" so it *is* form encoded
                contentType: "application/x-www-form-urlencoded; charset=UTF-8",
                dataType: "text", // the data type we want back, so text.  The data will come wrapped in xml
                success: function (data) {
                    $("#searchresultsC").html(data); // show the data inside the xml wrapper
                }
            });

            // SayHelloJson returns a .net object that has been converted into JSON format.  So the method still return a
            // string, but that string is an object in JSON format.  It is basically an object within an object.  We still
            // get the "d" property back as in Example B, but "d" is an object represented in JSON format itself.

            // Example D - call a function that returns a string that is an object in JSON format.
            // Params are sent in JSON format, data that comes back is a string that represents an object in JSON format
            $.ajax({
                type: "POST",
                url: "MyWebService.asmx/SayHelloJson",
                data: "{ firstName: 'Aidy', lastName: 'F' }",
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                success: function (data) {
                    var myData = JSON.parse(data.d); // data.d is a JSON formatted string, to turn it into a JSON object
                                                     // we use JSON.parse
                    // now that myData is a JSON object we can access its properties like normal
                    $("#searchresultsD").html(myData.Greeting + " " + myData.Name);
                }
            });

            // SayHelloObject returns a typed .net object.  The difference between this and Example D is that in Example D
            // the "d" property is an object in JSON format so we need to parse it to make it a JSON object.  Here the
            // "d" property is already an actual JSON object so no need to parse it.

            // Example E - call a function that returns an object.  .net will serialise the object as JSON for us.
            // Params are sent in JSON format, data that comes back is a JSON object
            $.ajax({
                type: "POST",
                url: "MyWebService.asmx/SayHelloObject",
                data: "{ firstName: 'Aidy', lastName: 'F' }",
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                success: function (data) {
                    var myData = data.d; // data.d is a JSON object that represents out SayHello class.
                    // As it is already a JSON object we can just start using it
                    $("#searchresultsE").html(myData.Greeting + " " + myData.Name);
                }
            });
        });
    </script>

    </form>
</body>
</html>
