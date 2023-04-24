(function ($) {
    "use strict";
    $(function () {
        let servers = JSON.parse($("#servers").text());
        let options = JSON.parse($("#options").text());
        let map = null;

        let resultsFetched = 0;

        $(document).ready(function () {
            let hashes = getHash();
            if (!jQuery.isEmptyObject(hashes)) {
                $("#type").val(hashes.type);
                $("#domain").val(hashes.domain);
                $("#input input[type=submit]").val(". . .");
                $("#input input[type=submit]").attr("disabled", true);
                for (let i = 0; i < servers.length; i++) {
                    getResults(i, servers[i].id, hashes.type, hashes.domain);
                }
            }
        });

        if ($("#map").length > 0) {
            $("#map").vectorMap({
                map: "world_mill",
                zoomOnScroll: !1,
                zoomButtons: !1,
                normalizeFunction: "polynomial",
                hoverOpacity: 0.7,
                hoverColor: false,
                markerStyle: {
                    initial: {
                        fill: "#FFF",
                        stroke: "#FFF",
                    },
                },
                backgroundColor: "transparent",
                regionStyle: {
                    initial: {
                        fill: options["colors"]["primary"],
                        stroke: options["colors"]["primary"],
                        "stroke-width": 1,
                        "stroke-opacity": 1,
                    },
                    hover: {
                        "fill-opacity": 1,
                        cursor: "default",
                    },
                },
                markers: servers.map(function (s) {
                    return { name: s.name, latLng: [s.lat, s.long] };
                }),
                onMarkerTipShow: function (e, el, index) {
                    var html =
                        '<div class="name"><img width="16px" src="/images/flags/' +
                        servers[index].country.toLowerCase() +
                        '.svg"> ' +
                        servers[index].name +
                        "</div>";
                    servers[index].result &&
                        (html +=
                            '<div class="result">' +
                            servers[index].result +
                            "</div>"),
                        el.html(html);
                },
                onRegionTipShow: function (e) {
                    e.preventDefault();
                },
            });
            map = $("#map").vectorMap("get", "mapObject");
            clearResults();
        }

        $("#input").on("submit", (e) => {
            e.preventDefault();
            clearResults();
            $("#input input[type=submit]").val(". . .");
            $("#input input[type=submit]").attr("disabled", true);
            let expected = $("#expected").val();
            let domain = $("#domain").val();
            domain = domain
                .replace("http://", "")
                .replace("https://", "")
                .split(/[/?#]/)[0];
            $("#domain").val(domain);
            let type = $("#type").val();
            setHash(domain, type);
            for (let i = 0; i < servers.length; i++) {
                getResults(i, servers[i].id, type, domain, expected);
            }
            map.reset();
        });

        function getResults(key, id, type, domain, expected) {
            $.ajax({
                url: `fetch/${domain}/${type}/${id}`,
                type: "POST",
                data: {
                    _token: document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content"),
                },
                success: function (data) {
                    if (data) {
                        $("#server-" + id + " .result").html(data);
                        servers[key].result = data;
                        if (map) {
                            if (
                                expected != undefined &&
                                expected != "" &&
                                expected != data
                            ) {
                                $("#server-" + id + " .status img").attr(
                                    "src",
                                    errorImg
                                );
                                map.markers[
                                    key
                                ].element.config.style.current.image = errorImg;
                            } else {
                                $("#server-" + id + " .status img").attr(
                                    "src",
                                    successImg
                                );
                                map.markers[
                                    key
                                ].element.config.style.current.image =
                                    successImg;
                            }
                        }
                    } else {
                        $("#server-" + id + " .status img").attr(
                            "src",
                            errorImg
                        );
                        servers[key].result = "";
                        if (map) {
                            map.markers[
                                key
                            ].element.config.style.current.image = errorImg;
                        }
                    }
                    resultsFetched++;
                    map.reset();
                    if (resultsFetched === servers.length) {
                        $("#input input[type=submit]").val("Find");
                        $("#input input[type=submit]").removeAttr("disabled");
                    }
                },
                error: function (data) {
                    console.error(
                        `Error on: ${servers[key].name} with message ${data}`
                    );
                    $("#server-" + id + " .status img").attr("src", errorImg);
                    if (map) {
                        map.markers[key].element.config.style.current.image =
                            errorImg;
                    }
                    resultsFetched++;
                    map.reset();
                    if (resultsFetched === servers.length) {
                        $("#input input[type=submit]").val(
                            options.find_btn.text
                        );
                        $("#input input[type=submit]").removeAttr("disabled");
                    }
                },
                timeout: options["timeout"] ? options["timeout"] * 1000 : 5000,
            });
        }

        function clearResults() {
            resultsFetched = 0;
            for (let i = 0; i < servers.length; i++) {
                $("#server-" + servers[i].id + " .result").html("");
                $("#server-" + servers[i].id + " .status img").attr(
                    "src",
                    pendingImg
                );
                if (map) {
                    map.markers[i].element.config.style.current.image =
                        pendingImg;
                }
                map.reset();
            }
        }

        function setHash(domain, type) {
            location.hash = `#/${type}/${domain}`;
        }

        function getHash() {
            const hashes = location.hash.split("/");
            if (hashes[2] !== undefined && hashes[1] !== undefined) {
                return {
                    domain: hashes[2],
                    type: hashes[1],
                };
            } else {
                return {};
            }
        }
    });
})(jQuery);

//Reload if 100 minutes are passed
let start = new Date();
setInterval(() => {
    if ((new Date() - start) / (1000 * 60) > 100) {
        location.reload();
    }
}, 1000);

if (typeof Shortcode !== "undefined") {
    new Shortcode(document.querySelector("body"), {
        blogs: function () {
            var data = '<div class="blogs row">';
            var fetchUrl =
                this.options.url +
                "/wp-json/wp/v2/posts?_fields[]=link&_fields[]=title&_fields[]=excerpt";
            var filters = {
                context: this.options.context,
                page: this.options.page,
                per_page: this.options.per_page,
                search: this.options.search,
                after: this.options.after,
                author: this.options.author,
                author_exclude: this.options.author_exclude,
                before: this.options.before,
                exclude: this.options.exclude,
                include: this.options.include,
                offset: this.options.offset,
                order: this.options.order,
                orderby: this.options.orderby,
                slug: this.options.slug,
                status: this.options.status,
                categories: this.options.categories,
                categories_exclude: this.options.categories_exclude,
                tags: this.options.tags,
                tags_exclude: this.options.tags_exclude,
                sticky: this.options.sticky,
            };
            Object.keys(filters).forEach(function (key) {
                if (filters[key]) {
                    fetchUrl += "&" + key + "=" + filters[key];
                }
            });
            fetch(fetchUrl)
                .then((response) => response.json())
                .then((blogs) => {
                    blogs.forEach(function (item) {
                        data += '<div class="blog-item col-md-6">';
                        data += '<a href="' + item.link + '" target="_blank">';
                        data +=
                            '<span class="title">' +
                            item.title.rendered +
                            "</span>";
                        data +=
                            '<span class="excerpt">' +
                            item.excerpt.rendered +
                            "</span>";
                        data += "</a>";
                        data += "</div>";
                    });
                    data += "</div>";
                    if (blogs.length) {
                        document.getElementById("blogs").innerHTML = data;
                    } else {
                        document.getElementById("blogs").innerHTML =
                            '<div class="no-content">204 - NO CONTENT AVAILABLE</div>';
                    }
                });
            return "<div id='blogs'><div class='content-loader'><div class='spinner-border' role='status'><span class='sr-only'>Loading...</span></div></div>";
        },
        html: function () {
            let txt = document.createElement("textarea");
            txt.innerHTML = this.contents;
            return txt.value;
        },
    });
}
