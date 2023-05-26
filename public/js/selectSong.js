(function () {
    $("#find").click(function () {
        $.ajax({
            url: "https://www.googleapis.com/youtube/v3/search",
            method: "GET",
            dataType: "json",
            data: {
                "q": $("#search").val() + " karaoke | videoke -stingray",
                //"q" : $("#search").val(),
                "part": "snippet",
                "key": "AIzaSyAfkllfZQsYePp7awEwrt7-t1i8hmJHB0Q",
                "maxResults": 10,
                "videoEmbeddable": "true",
                "videoSyndicated": "true",
                "safeSearch": "strict",
                "type": "video"
            },
            beforeSend: function () {
                $("#find").html("Finding");
                $("#find")[0].disabled = true;
                $("#search")[0].disabled = true;
            },
            success: function (data) {
                $("#results")[0].classList.remove("jk-hidden");
                let resHtml = "";
                $("#find").html("Go");
                $("#find")[0].disabled = false;
                $("#search")[0].disabled = false;
                console.log(data);
                resHtml += "<h5>Displaying Top " + data.items.length + " Results.</h5>";
                resHtml += "<p>Click to Reserve</p>";

                if (data.items.length > 0) {
                    for (let i = 0; i < data.items.length; i++) {
                        let thumbNail = data.items[i].snippet.thumbnails.default;
                        resHtml += "<a href='select/reserve/" + data.items[i].id.videoId + "/" + data.items[i].snippet.title.toUpperCase() + "'><img src='" + thumbNail.url + "'> " + data.items[i].snippet.title + "</a>";
                        resHtml += "<hr/>";
                    }
                } else {
                    resHtml += "No results found.";
                }

                $("#results").html(resHtml);
            },
            error: function (a, b, c) {
                console.log(a);
                console.log(b);
                console.log(c);
            }
        });
    });
})();