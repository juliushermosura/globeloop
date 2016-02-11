(function (a) {
    function oa(r, ea) {
        r = typeof r === "string" ? document.getElementById(r) : r;
        var O = r.cloneNode(false);
        O.innerHTML = ea;
        r.parentNode.replaceChild(O, r);
        return O
    }
    a.arrowchat = function () {
        function P() {
			clearTimeout(Z);
            a.ajax({
                url: k + "includes/json/receive/receive_buddylist.php",
                cache: false,
                type: "post",
                dataType: "json",
                success: function (b) {
                    Va(b);
                }
            });
			if (typeof c_list_heart_beat != "undefined") {
				var BLHT = c_list_heart_beat * 1000;
			} else {
				var BLHT = 60000;
			}
            Z = setTimeout(function () {
                P()
            }, BLHT)
        }
        function Sa(b) {
         if (a(b).attr("id"))
            var c = a(b).attr("id").substr(19);
         else
            var c = "";
            if (c == "") c = a(b).parent().attr("id").substr(19);
			a("#arrowchat_userlist_" + c + " .mobile_alert").hide();
            I(c, uc_name[c], uc_status[c], uc_avatar[c], uc_link[c])
        }
        function Va(b) {
            var c = {},
                d = "";
            c.available = "";
            c.busy = "";
            c.offline = "";
            c.away = "";
            onlineNumber = buddylistreceived = 0;
            b && a.each(b, function (i, e) {
                if (i == "buddylist") {
                    buddylistreceived = 1;
                    totalFriendsNumber = onlineNumber = 0;
                    a.each(e, function (l, f) {
                        longname = f.n.length > 25 ? f.n.substr(0, 25) + "..." : f.n;
                        if (f.s == "available" || f.s == "away" || f.s == "busy") onlineNumber++;
                        totalFriendsNumber++;
                        c[f.s] += '<li data-theme="c" class="ui-btn ui-btn-icon-right ui-li-has-arrow ui-li ui-btn-up-c"><div class="ui-btn-inner ui-li"><div class="ui-btn-text" id="arrowchat_userlist_' + f.id + '"><a data-transition="slide" href="#page2" class="ui-link-inherit user-window">' + longname + '<div class="mobile_alert">'+lang[115]+'</div></a></div><span class="ui-icon ui-icon-arrow-r ui-icon-shadow"></span></div></li>';
                        uc_status[f.id] = f.s;
                        uc_name[f.id] = f.n;
                        uc_avatar[f.id] = f.a;
                        uc_link[f.id] = f.l
                    })
                }
                if (buddylistreceived == 1) {
					for (buddystatus in c) {
						if (c.hasOwnProperty(buddystatus)) {
							if (c[buddystatus] != "") {
								a("#buddylist-container-available").html('<li role="heading" data-role="list-divider" id="online-users-count" class="ui-li ui-li-divider ui-btn ui-bar-d ui-btn-up-undefined">' + lang[111] + '</li>' + c['available']);
								a("#buddylist-container-away").html('<li role="heading" data-role="list-divider" id="online-users-count" class="ui-li ui-li-divider ui-btn ui-bar-d ui-btn-up-undefined">' + lang[112] + '</li>' + c['away']);
							}
						}
					}
                    a(".user-window").click(function (l) {
                        Sa(l.target);
                    });
					a("#back-button").click(function () {
						j = "";
					});
                    R = onlineNumber;
                    totalFriendsNumber == 0 && a("#arrowchat_popout_friends").html('<div class="arrowchat_nofriends">' + lang[8] + "</div>");
					a("#buddylist-container-away").css("margin-top", "15px");
                    buddylistreceived = 0
                }
            })
        }
        function DTitChange(name) {
            if (dtit2 != 2) {
                document.title = lang[30] + " " + name + "!";
                dtit2 = 2
            } else {
                document.title = dtit;
                dtit2 = 1
            }
            if (window_focus == false) {
                dtit3 = setTimeout(function () {
                    DTitChange(name)
                }, 1000)
            } else {
                document.title = dtit;
                clearTimeout(dtit3);
            }
        }
        function replaceURLWithHTMLLinks(text) {
            var exp = /(\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/ig;
            return text.replace(exp, "<a href='$1'>$1</a>");
        }
        function smileyreplace(mess) {
            for (i = 0; i < Smiley.length; i++) {
                check_emoticon = mess.lastIndexOf(Smiley[i][1]);
                if (check_emoticon != -1) {
                    mess = mess.replace(Smiley[i][1], '<img class="arrowchat_smiley" height="16" width="16" src="' + k + "themes/" + u_theme + '/images/smilies/' + Smiley[i][0] + '.gif" alt="" />');
                }
            }
            return mess;
        }
        function Oa(b) {
            I(b, uc_name[b], uc_status[b], uc_avatar[b], uc_link[b], 1)
        }
        function sa(b, c, d) {
            if (uc_name[b] == null || uc_name[b] == "") setTimeout(function () {
                sa(b, c, d)
            }, 500);
            else {
                Oa(b);
                if (d == 1) if (a("#arrowchat_popout_user_" + b + " .arrowchat_popout_alert").length > 0) c = parseInt(a("#arrowchat_popout_user_" + b + " .arrowchat_popout_alert").html()) + parseInt(c);
                if (c == 0) {
                    a("#arrowchat_popout_user_" + b + " .arrowchat_popout_alert").remove();
                } else {
                    if (a("#arrowchat_popout_user_" + b + " .arrowchat_popout_alert").length > 0) {
                        a("#arrowchat_popout_user_" + b + " .arrowchat_popout_alert").html(c);
                    } else a("<div/>").addClass("arrowchat_popout_alert").html(c).appendTo(a("#arrowchat_popout_user_" + b + " .arrowchat_popout_wrap"));
                }
                y[b] = c;
                S();
            }
        }
        function S() {
            var b = "",
                c = 0;
            for (chatbox in y) if (y.hasOwnProperty(chatbox)) if (y[chatbox] != null) {
                b += chatbox + "|" + y[chatbox] + ",";
                if (y[chatbox] > 0) c = 1
            }
            Ka = c;
            b.slice(0, -1)
        }
        function H() {
            var url = k + "includes/json/receive/receive_core.php?hash=" + u_hash_id + "&init=" + acsi;
            xOptions = a.ajax({
                url: url,
				dataType: "jsonp",
                success: function (b) {
                    V.timestamp = ma;
                    var c = "",
                        d = {};
                    d.available = "";
                    d.busy = "";
                    d.offline = "";
                    d.away = "";
                    onlineNumber = buddylistreceived = 0;
                    if (b && b != null) {
                        var i = 0;
                        a.each(b, function (e, l) {
							if (e == "popout") {
								window.close();
							}
                            if (e == "typing") {
                                a.each(l, function (f, h) {
                                    if (h.is_typing == "1") {
                                        receiveTyping(h.typing_id);
                                    } else {
                                        receiveNotTyping(h.typing_id);
                                    }
                                });
                            }
                            if (e == "messages") {
                                a.each(l, function (f, h) {
									receiveMessage(h.id, h.from, h.message, h.sent, h.self, h.old);
                                });
                                K = 1;
                                d != 1 && u_sounds == 1 && Ua();
                                D = E
                            }
                        });
                        j != "" && i > 0 && za(j, c)
                    }
                    if ($ != 1 && w != 1) {
                        K++;
                        if (K > 4) {
                            D *= 2;
                            K = 1
                        }
                        if (D > 12E3) D = 12E3
                    }
                    acsi++;
                    window.onblur = function () {
                        window_focus = false
                    };
                    window.onfocus = function () {
                        window_focus = true
                    };
					if (isAway == 1) {
						var CHT = c_heart_beat * 1000 * 3;
					} else {
						var CHT = c_heart_beat * 1000;
					}
					if (c_push_engine != 1) {
						CHA = setTimeout(function () {
							H()
						}, CHT);
					}
                }
            });
        }
        function X(b, c, d, i, e, l, f) {
            aa[b] != 1 && I(b, uc_name[b], uc_status[b], uc_avatar[b], uc_link[b], 1, 1);
            if (uc_name[b] == null || uc_name[b] == "") setTimeout(function () {
                X(b, c, d, i, e, l, f)
            }, 500);
            else {
                var h = "";
                if (parseInt(d) == 1) {
                    fromname = u_name;
                    h = " arrowchat_self"
                } else fromname = uc_name[b];
				var full_name = fromname;
                if (parseInt(l) == 1) c = c.replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/\n/g, "<br>").replace(/\"/g, "&quot;");
                c = replaceURLWithHTMLLinks(c);
                c = smileyreplace(c);
                d != 1 && u_sounds == 1 && Ua();
                separator = ":&nbsp;&nbsp;";
                if (a("#arrowchat_message_" + e).length > 0) a("#arrowchat_message_" + e + " .arrowchat_chatboxmessagecontent").html(c);
                else {
                    sentdata = "";
                    if (f != null) sentdata = ha(new Date(f * 1E3));
					if (c_show_full_name != 1) {
						if (fromname.indexOf(" ") != -1) fromname = fromname.slice(0, fromname.indexOf(" "));
					}
                    var o = uc_name[b];
                    if (o.indexOf(" ") != -1) o = o.slice(0, o.indexOf(" "));
                    if (uc_status[b] == "offline") a("#arrowchat_user_" + b).append('<div class="arrowchat_chatboxmessage" id="arrowchat_message_' + e + '"><div class="arrowchat_chatboxmessagefrom' + h + '"><div style="float:right;">' + sentdata + "</div><strong>" + fromname + '</strong><br /></div><div class="arrowchat_chatboxmessagecontent_offline' + h + '"><div class="arrowchat_offline_send_text">' + o + lang[13] + "</div>" + c + "</div></div>");
                    else if (f - B > 60 || B == null || N != full_name) {
                        a("#arrowchat_user_" + b).append('<div class="arrowchat_chatboxmessage" id="arrowchat_message_' + e + '"><div class="arrowchat_chatboxmessagefrom' + h + '"><div style="float:right;">' + sentdata + "</div><strong>" + fromname + '</strong><br /></div><div class="arrowchat_chatboxmessagecontent' + h + '" style="margin-left: 0">' + c + "</div></div>");
                        B = f;
                        N = full_name;
                    } else a("#arrowchat_user_" + b).append('<div class="arrowchat_chatboxmessage" id="arrowchat_message_' + e + '"><div class="arrowchat_chatboxmessagecontent' + h + '" style="margin-left: 0">' + c + "</div></div>");
                    a('html, body').animate({scrollTop: a('#page2').height()}, 0);
                }
                j != b && i != 1 && sa(b, 1, 1)
            }
        }
        function za(b, c) {
            if (uc_name[b] == null || uc_name[b] == "") setTimeout(function () {
                za(b, c)
            }, 500);
            else {
                a("#arrowchat_user_" + b).append(c);
                a('html, body').animate({scrollTop: a('#page2').height()}, 0);
                G[b] = 1
            }
        }
        function ya(b) {
            if (uc_name[b] == null || uc_name[b] == "") setTimeout(function () {
                ya(b)
            }, 500);
            else j != b && a("#arrowchat_popout_user_" + b).click()
        }
        function Ua() {
            swfobject.embedSWF(k + "themes/" + u_theme + "/sounds/new%5Fmessage.player.swf?soundswf="+k+"themes/" + u_theme + "/sounds/new%5Fmessage.swf&autoplay=1&loops=0", "arrowchat_sound_player_holder", "1", "1", "9.0.0");
        }
        function I(b, c, d, e, l, f, h) {
            if (!(b == null || b == "")) if (uc_name[b] == null || uc_name[b] == "") if (aa[b] != 1) {
                aa[b] = 1;
                a.ajax({
                    url: k + "includes/json/receive/receive_user.php",
                    data: {
                        userid: b
                    },
                    type: "post",
                    cache: false,
                    success: function (o) {
                        if (o) {
                            c = uc_name[b] = o.n;
                            d = uc_status[b] = o.s;
                            e = uc_avatar[b] = o.a;
                            l = uc_link[b] = o.l;
                            aa[b] = 0;
                            if (c != null) {
                                qa(b, c, d, e, l, f, h)
                            } else {
                                a.post(k + "includes/json/send/send_settings.php", {
                                    userid: u_id,
                                    unfocus_chat: b
                                }, function () {})
                            }
                        }
                    }
                })
            } else setTimeout(function () {
                I(b, uc_name[b], uc_status[b], uc_avatar[b], uc_link[b], f, h)
            }, 500);
            else qa(b, uc_name[b], uc_status[b], uc_avatar[b], uc_link[b], f, h)
        }
        function ha(b) {
            var c = "am",
                d = b.getHours(),
                i = b.getMinutes(),
                e = b.getDate();
            b = b.getMonth();
            if (d > 11) c = "pm";
            if (d > 12) d -= 12;
            if (d == 0) d = 12;
            if (d < 10) d = d;
            if (i < 10) i = "0" + i;
            var l = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                f = "th";
            if (e == 1 || e == 21 || e == 31) f = "st";
            else if (e == 2 || e == 22) f = "nd";
            else if (e == 3 || e == 23) f = "rd";
			if (c_us_time != 1) {
				return e != Na ? '<span class="arrowchat_ts">' + g + ":" + i + " " + e + f + " " + l[b] + "</span>" : '<span class="arrowchat_ts">' + g + ":" + i + "</span>"
			} else {
				return e != Na ? '<span class="arrowchat_ts">' + d + ":" + i + c + " " + e + f + " " + l[b] + "</span>" : '<span class="arrowchat_ts">' + d + ":" + i + c + "</span>"
			}
        }
        function La(b) {
            a.ajax({
                cache: false,
                url: k + "includes/json/receive/receive_history.php",
                data: {
                    chatbox: b
                },
                type: "post",
                success: function (c) {
                    if (c) {
                        a("#arrowchat_user_" + b + "_popup .arrowchat_popout_convo").html("");
                        B = null;
                        var d = "",
                            i = uc_name[b];
                        a.each(c, function (e, l) {
                            e == "messages" && a.each(l, function (f, h) {
                                f = "";
                                if (h.self == 1) {
                                    fromname = u_name;
                                    f = " arrowchat_self";
                                    _aa5 =
                                    _aa4 = ""
                                } else {
                                    fromname = i;
                                    _aa4 = '<a target="_blank" href="' + uc_link[b] + '">';
                                    _aa5 = "</a>"
                                }
								var full_name = fromname;
                                var o = new Date(h.sent * 1E3);
								if (c_show_full_name != 1) {
									if (fromname.indexOf(" ") != -1) fromname = fromname.slice(0, fromname.indexOf(" "));
								}
								if (a("#arrowchat_message_" + h.id).length > 0) {
									a("#arrowchat_message_" + h.id + " .arrowchat_chatboxmessagecontent").html(h.message);
								} else {
									if (h.sent - B > 60 || B == null || N != full_name) {
										d += '<div class="arrowchat_chatboxmessage" id="arrowchat_message_' + h.id + '"><div class="arrowchat_chatboxmessagefrom' + f + '"><div style="float:right;">' + ha(o) + "</div><strong>" + _aa4 + fromname + _aa5 + '</strong><br /></div><div class="arrowchat_chatboxmessagecontent' + f + '" style="margin-left:0">' + h.message + "</div></div>";
										B = h.sent;
										N = full_name;
									} else d += '<div class="arrowchat_chatboxmessage" id="arrowchat_message_' + h.id + '"><div class="arrowchat_chatboxmessagecontent' + f + '" style="margin-left:0">' + h.message + "</div></div>"
								}
                            })
                        });
                        if (a("#arrowchat_user_" + b).length > 0) oa("arrowchat_user_" + b, d + document.getElementById("arrowchat_user_" + b).innerHTML);
                        else document.getElementById("arrowchat_user_" + b).innerHTML = d;
						setTimeout(function() {
							a('html, body').animate({scrollTop: a('#page2').height()}, 0);
						}, 400);
                    }
                }
            })
        }
        function ea(atid) {
            a.post(k + "includes/json/send/send_typing.php", {
                userid: u_id,
                typing: atid,
                untype: 1
            }, function () {});
            fa = -1
        }
        function O(b, c, d) {
            clearTimeout(pa);
            pa = setTimeout(function () {
                ea(d)
            }, 5E3);
            if (fa != d) {
                a.post(k + "includes/json/send/send_typing.php", {
                    userid: u_id,
                    typing: d
                }, function () {});
                fa = d
            }
            if (b.keyCode == 13 && b.shiftKey == 0) {
                var i = a(c).val();
                i = i.replace(/^\s+|\s+$/g, "");
                a(c).val("");
                a(c).focus();
                i != "" && a.post(k + "includes/json/send/send_message.php", {
                    userid: u_id,
                    to: d,
                    message: i
                }, function (e) {
                    if (e) {
                        X(d, i, "1", "1", e, 1, Math.floor((new Date).getTime() / 1E3));
                        a('html, body').animate({scrollTop: a('#page2').height()}, 0);
                    }
                    K = 1;
                    if (D > E) {
                        D = E;
                        clearTimeout(Y);
                        Y = setTimeout(function () {
                            H()
                        }, E)
                    }
                });
                return false
            }
        }
        function Ca(b, c, d) {
            a('html, body').animate({scrollTop: a('#page2').height()}, 0);
        }
        function qa(b, c, d, e, l, f) {
			a("#username-header").html(c);
			if (b != j) {
				a(".chat_user_content").html("");
			}
			a(".chat_user_content").attr("id", "arrowchat_user_" + b);
			a('html, body').animate({scrollTop: a('#page2').height()}, 0);
                shortname = c.length > 12 ? c.substr(0, 12) + "..." : c;
                longname = c.length > 24 ? c.substr(0, 24) + "..." : c;
                a("#textinput1").keydown(function (h) {
                    return O(h, this, j)
                });
                a("#textinput1").keyup(function (h) {
                    return Ca(h, this, j)
                });
				a("#send_button").click(function () {
					var c = a("#textinput1");
					var i = a(c).val();
					i = i.replace(/^\s+|\s+$/g, "");
					a(c).val("");
					i != "" && a.post(k + "includes/json/send/send_message.php", {
						userid: u_id,
						to: j,
						message: i
					}, function (e) {
						if (e) {
							X(j, i, "1", "1", e, 1, Math.floor((new Date).getTime() / 1E3));
							a('html, body').animate({scrollTop: a('#page2').height()}, 0);
						}
						K = 1;
						if (D > E) {
							D = E;
							clearTimeout(Y);
							Y = setTimeout(function () {
								H()
							}, E)
						}
					});
				});
				a("#arrowchat_userlist_" + b).click(function () {
					var tba = 0;
                    if (a("#arrowchat_popout_user_" + b + " .arrowchat_popout_alert").length > 0) {
                        tba = 1;
                        a("#arrowchat_popout_user_" + b + " .arrowchat_popout_alert").remove();
                        G[b] = 0;
                        y[b] = 0;
                        S()
                    }
					if (j != "") {
						a("#arrowchat_popout_user_" + j).removeClass("arrowchat_popout_focused");
						a("#arrowchat_popout_user_" + j + "_convo").removeClass("arrowchat_popout_convo_focused");
						j = ""
					}
					La(b);
					a.post(k + "includes/json/send/send_settings.php", {
						userid: u_id,
						focus_chat: b,
						tab_alert: tba
					}, function () {});
					a(this).addClass("arrowchat_popout_focused");
					a("#arrowchat_popout_user_" + b + "_convo").addClass("arrowchat_popout_convo_focused");
					j = b;
                    a('html, body').animate({scrollTop: a('#page2').height()}, 0);
				});
				f != 1 && a("#arrowchat_popout_user_" + b).click();
				y[b] = 0;
				G[b] = 0;
        }
		function stripslashes(str) {
			str=str.replace(/\\'/g,'\'');
			str=str.replace(/\\"/g,'"');
			str=str.replace(/\\0/g,'\0');
			str=str.replace(/\\\\/g,'\\');
			return str;
		}
		function receiveMessage(id, from, message, sent, self, old) {
			if (j == "") {
				a("#arrowchat_userlist_" + from + " .mobile_alert").show();
			}
			var c = "",
			ma = id;
			clearTimeout(dtit3);
			DTitChange(uc_name[from]);
			if (j == from && uc_name[from] != "" && uc_name[from] != null) {
				var o = uc_name[from];
				if (uc_status[from] == "offline") {
					P();
				}
				f = "";
				if (self == 1) {
					fromname = u_name;
					f = " arrowchat_self";
					_aa5 = _aa4 = ""
				} else {
					fromname = o;
					_aa4 = '<a target="_blank" href="' + uc_link[from] + '">';
					_aa5 = "</a>"
				}
				var full_name = fromname;
				message = stripslashes(message);
				message = replaceURLWithHTMLLinks(message);
				if (a("#arrowchat_message_" + id).length > 0) {
					a("#arrowchat_message_" + id + " .arrowchat_chatboxmessagecontent").html(message);
				} else {
					o = new Date(sent * 1E3);
					if (c_show_full_name != 1) {
						if (fromname.indexOf(" ") != -1) fromname = fromname.slice(0, fromname.indexOf(" "));
					}
					if (sent - B > 60 || B == null || N != full_name) {
						c += '<div class="arrowchat_chatboxmessage" id="arrowchat_message_' + id + '"><div class="arrowchat_chatboxmessagefrom' + f + '"><div style="float:right;">' + ha(o) + "</div><strong>" + _aa4 + fromname + _aa5 + '</strong><br/></div><div class="arrowchat_chatboxmessagecontent' + f + '" style="margin-left:0">' + message + "</div></div>";
						B = sent;
						N = full_name;
					} else c += '<div class="arrowchat_chatboxmessage" id="arrowchat_message_' + id + '"><div class="arrowchat_chatboxmessagecontent' + f + '" style="margin-left:0">' + message + "</div></div>"
				}
			} else {
				f = 0;
				if (!(a("#arrowchat_popout_user_" + from).length > 0)) {
					a.post(k + "includes/json/send/send_settings.php", {
						unfocus_chat: from
					}, function () {});
					f = 1
				}
				X(from, message, self, old, id, 0, sent);
				j == "" && 0 && ya(from)
			}
			j != "" && za(j, c);
			a('html, body').animate({scrollTop: a('#page2').height()}, 0);
		}
		function receiveTyping(id) {
			a("#arrowchat_popout_user_"+id+" .arrowchat_closebox_bottom_status").addClass("arrowchat_typing")
		}
		function receiveNotTyping(id) {
			a("#arrowchat_popout_user_"+id+" .arrowchat_closebox_bottom_status").removeClass("arrowchat_typing")
		}
		function pushSubscribe() {
			if (c_push_engine == 1) {
				push.subscribe({ "channel" : "u"+u_id, "callback" : function(data) { pushReceive(data); } });
			}
		}
		function pushReceive(data) {
			if ("typing" in data) {
				receiveTyping(data.typing.id);
			}
			if ("nottyping" in data) {
				receiveNotTyping(data.nottyping.id);
			}
			if ("messages" in data) {
				receiveMessage(data.messages.id, data.messages.from, data.messages.message, data.messages.sent, data.messages.self, data.messages.old);
				u_sounds == 1 && Ua();
				K = 1;
				D = E;
			}
		}
        var bounce = 0,
            bounce2 = 0,
            count = 0,
            V = {},
            dtit = document.title,
            dtit2 = 1,
            dtit3, window_focus = true,
            xa = {},
            j = "",
            crou = "",
            $ = 0,
            w = 0,
            bli = 1,
			isAway = 0,
            chatroomreceived = 0,
            msgcount = 0,
            W = false,
            Y, Z, E = 3E3,
            Crref2, Ccr = -1,
            D = E,
            K = 1,
            ma = 0,
            R = 0,
            m = "",
            Ka = 0,
            crt = {},
            crt2 = {},
            y = {},
            G = {},
            aa = {},
            ca = {},
            Aa = new Date,
            Na = Aa.getDate(),
            ab = Math.floor(Aa.getTime() / 1E3),
            acsi = 1,
            Q = 0,
            fa = -1,
            acp = "Powered By ArrowChat",
            pa = 0,
            B, N;
        var _ts = "",
            _ts2;
        for (d = 0; d < Themes.length; d++) {
            if (Themes[d][2] == u_theme) {
                _ts2 = "selected";
            } else {
                _ts2 = "";
            }
            _ts = _ts + "<option value=\"" + Themes[d][0] + "\" " + _ts2 + ">" + Themes[d][1] + "</option>";
        }
        arguments.callee.videoWith = function (b) {
            var win = window.open(k + 'video_chat.php?rid=' + b, 'audiovideochat', "status=no,toolbar=no,menubar=no,directories=no,resizable=no,location=no,scrollbars=no,width=650,height=610");
            win.focus();
        };
		function Xa() {
			if (c_push_engine == 1) {
				push = PUBNUB.init({
					publish_key   : c_push_publish,
					subscribe_key : c_push_subscribe
				});
			}
			if (c_push_engine == 1) {
				pushSubscribe();
			}
			H();
			P();
		}
        a.ajaxSetup({
            scriptCharset: "utf-8",
            cache: false
        });
        arguments.callee.runarrowchat = function () {
            Xa()
        };
    }
})(jqac);
(jqac);
jqac(document).ready(function () {
    jqac.arrowchat();
    jqac.arrowchat.runarrowchat()
});