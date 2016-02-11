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
                url: k + "includes/json/receive/receive_buddylist.php?popout=1",
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
                        longname = f.n.length > 16 ? f.n.substr(0, 16) + "..." : f.n;
                        if (G[f.id] != null) {
                            a("#arrowchat_popout_user_" + f.id + " .arrowchat_closebox_bottom_status").removeClass("arrowchat_available").removeClass("arrowchat_busy").removeClass("arrowchat_offline").removeClass("arrowchat_away").addClass("arrowchat_" + f.s);
                        }
                        if (f.s == "available" || f.s == "away" || f.s == "busy") onlineNumber++;
                        totalFriendsNumber++;
                        c[f.s] += '<div id="arrowchat_userlist_' + f.id + '" class="arrowchat_userlist" onmouseover="jqac(this).addClass(\'arrowchat_userlist_hover\');" onmouseout="jqac(this).removeClass(\'arrowchat_userlist_hover\');"><img class="arrowchat_userlist_avatar ' + d + '" src="' + f.a + '" /><span class="arrowchat_userscontentname">' + longname + '</span><span class="arrowchat_userscontentdot arrowchat_' + f.s + '"></span></div>';
                        uc_status[f.id] = f.s;
                        uc_name[f.id] = f.n;
                        uc_avatar[f.id] = f.a;
                        uc_link[f.id] = f.l
                    })
                }
                if (buddylistreceived == 1) {
                    for (buddystatus in c) if (c.hasOwnProperty(buddystatus)) c[buddystatus] == "" ? a("#arrowchat_userslist_" + buddystatus).html("") : oa("arrowchat_userslist_" + buddystatus, "<div>" + c[buddystatus] + "</div>");
                    a(".arrowchat_userlist").click(function (l) {
                        Sa(l.target)
                    });
                    R = onlineNumber;
                    totalFriendsNumber == 0 && a("#arrowchat_popout_friends").html('<div class="arrowchat_nofriends">' + lang[8] + "</div>");
                    buddylistreceived = 0
                }
				if (c_disable_avatars == 1 || u_no_avatars == 1) {
					a(".arrowchat_userlist_avatar").hide();
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
		function M() {
			a(".arrowchat_popout_convo").css("height", a(window).height() - a("#arrowchat_popout_open_chats").height() - 70);
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
                    if (uc_status[b] == "offline") a("#arrowchat_popout_user_" + b + "_convo .arrowchat_popout_convo").append('<div class="arrowchat_chatboxmessage" id="arrowchat_message_' + e + '"><div class="arrowchat_chatboxmessagefrom' + h + '"><div style="float:right;">' + sentdata + "</div><strong>" + fromname + '</strong><br /></div><div class="arrowchat_chatboxmessagecontent_offline' + h + '"><div class="arrowchat_offline_send_text">' + o + lang[13] + "</div>" + c + "</div></div>");
                    else if (f - B > 60 || B == null || N != full_name) {
                        a("#arrowchat_popout_user_" + b + "_convo .arrowchat_popout_convo").append('<div class="arrowchat_chatboxmessage" id="arrowchat_message_' + e + '"><div class="arrowchat_chatboxmessagefrom' + h + '"><div style="float:right;">' + sentdata + "</div><strong>" + fromname + '</strong><br /></div><div class="arrowchat_chatboxmessagecontent' + h + '" style="margin-left: 0">' + c + "</div></div>");
                        B = f;
                        N = full_name;
                    } else a("#arrowchat_popout_user_" + b + "_convo .arrowchat_popout_convo").append('<div class="arrowchat_chatboxmessage" id="arrowchat_message_' + e + '"><div class="arrowchat_chatboxmessagecontent' + h + '" style="margin-left: 0">' + c + "</div></div>");
                    a("#arrowchat_popout_text_" + b).scrollTop(5E4)
                }
                j != b && i != 1 && sa(b, 1, 1)
            }
        }
        function za(b, c) {
            if (uc_name[b] == null || uc_name[b] == "") setTimeout(function () {
                za(b, c)
            }, 500);
            else {
                a("#arrowchat_popout_text_" + b).append("<div>" + c + "</div>");
                a("#arrowchat_popout_text_" + b).scrollTop(5E4);
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
                            if (G[b] != null) {
                                a("#arrowchat_popout_user_" + b + " .arrowchat_closebox_bottom_status").removeClass("arrowchat_available").removeClass("arrowchat_busy").removeClass("arrowchat_offline").addClass("arrowchat_" + d);
                            }
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
                        if (a("#arrowchat_popout_text_" + b).length > 0) oa("arrowchat_popout_text_" + b, "<div>" + d + "</div>" + document.getElementById("arrowchat_popout_text_" + b).innerHTML);
                        else document.getElementById("arrowchat_popout_text_" + b).innerHTML = "<div>" + d + "</div>";
                        a("#arrowchat_popout_text_" + b).scrollTop(5E4);
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
                        a("#arrowchat_popout_user_" + d + "_convo .arrowchat_popout_convo").scrollTop(a("#arrowchat_popout_user_" + d + "_convo .arrowchat_popout_convo")[0].scrollHeight)
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
            a("#arrowchat_popout_user_" + d + "_popup .arrowchat_popout_convo").scrollTop(a("#arrowchat_popout_user_" + d + "_convo .arrowchat_popout_convo")[0].scrollHeight)
        }
        function qa(b, c, d, e, l, f) {
            if (G[b] != null) {
                if (!a("#arrowchat_user_" + b).hasClass("arrowchat_tabclick") && f != 1) {
                    if (j != "") {
						a("#arrowchat_popout_user_" + j).removeClass("arrowchat_popout_focused");
                        j = ""
                    }
                }
            } else {
                shortname = c.length > 12 ? c.substr(0, 12) + "..." : c;
                longname = c.length > 24 ? c.substr(0, 24) + "..." : c;
                a("<div/>").attr("id", "arrowchat_popout_user_" + b).addClass("arrowchat_popout_tab").html('<div class="arrowchat_bar_left"><div class="arrowchat_popout_wrap"><div class="arrowchat_popout_tab_name">' + shortname + '</div><div class="arrowchat_closebox_bottom_status arrowchat_' + d + '" style="margin-top:4px;"></div></div></div><div class="arrowchat_popout_right"><div class="arrowchat_closebox_bottom"></div></div>').appendTo(a("#arrowchat_popout_container"));
				a("<div/>").attr("id", "arrowchat_popout_user_" + b + "_convo").addClass("arrowchat_popout_convo_wrapper").html('<div id="arrowchat_popout_text_' + b + '" class="arrowchat_popout_convo"></div><div class="arrowchat_popout_input_container"><div class="arrowchat_popout_input_wrapper"><textarea class="arrowchat_popout_convo_input"></textarea></div></div>').appendTo(a("#arrowchat_popout_chat"));
                a("#arrowchat_popout_user_" + b + " .arrowchat_closebox_bottom").mouseenter(function () {
                    a(this).addClass("arrowchat_closebox_bottomhover")
                });
                a("#arrowchat_popout_user_" + b + " .arrowchat_closebox_bottom").mouseleave(function () {
                    a(this).removeClass("arrowchat_closebox_bottomhover")
                });
                a("#arrowchat_popout_user_" + b + " .arrowchat_closebox_bottom").click(function () {
                    a.post(k + "includes/json/send/send_settings.php", {
                        userid: u_id,
                        close_chat: b,
                        tab_alert: 1
                    }, function () {});
					a("#arrowchat_popout_user_" + b + "_convo").remove();
                    a("#arrowchat_popout_user_" + b).remove();
                    if (j == b) j = "";
                    y[b] = null;
                    G[b] = null;
                    ca[b] = 0;
                });
                a("#arrowchat_popout_user_" + b + "_convo .arrowchat_popout_convo_input").keydown(function (h) {
                    return O(h, this, b)
                });
                a("#arrowchat_popout_user_" + b + "_convo .arrowchat_popout_convo_input").keyup(function (h) {
                    return Ca(h, this, b)
                });
				a("#arrowchat_popout_user_" + b).click(function () {
					var tba = 0;
                    if (a("#arrowchat_popout_user_" + b + " .arrowchat_popout_alert").length > 0) {
                        tba = 1;
                        a("#arrowchat_popout_user_" + b + " .arrowchat_popout_alert").remove();
                        G[b] = 0;
                        y[b] = 0;
                        S()
                    }
                    if (a(this).hasClass("arrowchat_popout_focused")) {
                        a(this).removeClass("arrowchat_popout_focused");
						a("#arrowchat_popout_user_" + b + "_convo").removeClass("arrowchat_popout_convo_focused");
                        j = "";
                        a.post(k + "includes/json/send/send_settings.php", {
                            userid: u_id,
                            unfocus_chat: b,
                            tab_alert: 1
                        }, function () {})
                    } else {
                        if (j != "") {
                            a("#arrowchat_popout_user_" + j).removeClass("arrowchat_popout_focused");
							a("#arrowchat_popout_user_" + j + "_convo").removeClass("arrowchat_popout_convo_focused");
                            j = ""
                        }
                        if (ca[b] != 1) {
                            La(b);
                            ca[b] = 1
                        }
                        a.post(k + "includes/json/send/send_settings.php", {
                            userid: u_id,
                            focus_chat: b,
                            tab_alert: tba
                        }, function () {});
						a(this).addClass("arrowchat_popout_focused");
						a("#arrowchat_popout_user_" + b + "_convo").addClass("arrowchat_popout_convo_focused");
						j = b;
						a("#arrowchat_popout_user_" + b + "_convo .arrowchat_popout_convo_input").focus()
					}
                    a("#arrowchat_popout_user_" + b + "_convo .arrowchat_popout_convo").scrollTop(a("#arrowchat_popout_user_" + b + "_convo .arrowchat_popout_convo")[0].scrollHeight);
				});
				f != 1 && a("#arrowchat_popout_user_" + b).click();
				y[b] = 0;
				G[b] = 0;
            }
			M();
        }
		function stripslashes(str) {
			str=str.replace(/\\'/g,'\'');
			str=str.replace(/\\"/g,'"');
			str=str.replace(/\\0/g,'\0');
			str=str.replace(/\\\\/g,'\\');
			return str;
		}
		function receiveMessage(id, from, message, sent, self, old) {
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
			a("#arrowchat_tabcontenttext_" + from).scrollTop(5E4);
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
            var win = window.open(k + 'public/video/?rid=' + b, 'audiovideochat', "status=no,toolbar=no,menubar=no,directories=no,resizable=no,location=no,scrollbars=no,width=650,height=610");
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
			M();
			a(window).bind("resize", M);
			for (var d = 0; d < unfocus_chat.length; d++) {
				I(unfocus_chat[d], uc_name[unfocus_chat[d]], uc_status[unfocus_chat[d]], uc_avatar[unfocus_chat[d]], uc_link[unfocus_chat[d]], "1");
			}
			if (u_chat_open != 0) { 
				I(u_chat_open, uc_name[u_chat_open], uc_status[u_chat_open], uc_avatar[u_chat_open], uc_link[u_chat_open], "0")
			}
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