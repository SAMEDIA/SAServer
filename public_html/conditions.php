<?
	$pageTitle = "SongAbout.FM | Discover what a song is about.";
	$page = "Homepage";
	$showSearch = true;	
	
	// This is the main infromation API
	$echoNestAPIKey = 'NQDRAK60G9OZIAAFL';
	require_once '/home/songabou/lib/EchoNest/Autoloader.php';
	EchoNest_Autoloader::register();
	$songAboutEchonest = new EchoNest_Client();
	$songAboutEchonest->authenticate($echoNestAPIKey);	
	
	require_once '/home/songabou/www/includes/staffPicksVar.php';
			
?>
<? 	include '/home/songabou/www/includes/header.php'; ?>
	<div id="contentHeaderWrapper" class="left sg-borderless"> 
        <div id="contentHeader" class="center">  
            <div id="aboutUsBox">
                <img src="/~songabou/images/aboutHeaderImage.png" width="975" height="187">
            </div>
        </div>
    </div>
    <div id="contentWrapper" class="left"> 
        <div id="songAboutContent" class="center">   
            <div id="songAboutBase" class="center">
                <div id="songAboutBaseTitle" class="center">
                    <p>Terms and Conditions </p>
                </div>
                <div class="left">
                    <strong>
                    <p>This Terms of Service (“TOS”) is an agreement between you and Songabout Media LLC (“Company”, “we”, “us” or “our”) </p>
                    <p>that allows you to use our websites and services as long as you follow the TOS. By accessing or using the website or </p>
                    <p>other Services (defined below), you signify your agreement to (collectively, the “Agreement”) (1) all terms and conditions </p>
                    <p>in this TOS, (2) our Privacy Policy located on our website, and (3) any other standard policies or community guidelines, if </p>
                    <p>any, posted on our website, which are expressly incorporated herein and must also be observed and followed.</p>
                    </strong>
                    <br>
                    <strong>To Use Our Services, You:</strong>
                   	<br>
                    <p>• May need to register with us to access and use some of our services and websites</p>
                    <p>• Must not initiate or participate in any activities on our services that are illegal, harmful, or interfere with anyone's use of our </p>
                    <p>services, including the sending of e-mail or instant messaging spam</p>
                    <br>
                    <strong>If You Post Content On a Service, You:</strong>
                    <br>
                    <p>• May post content that you create or have been given permission to post by the owner, is legal, and doesn't violate the </p>
                    <p>• Are responsible for content that you post to our services and assume all risks of posting personal information online</p>
                    <p>• Continue to own the content but grant us a license to use and distribute your content, subject to and in accordance with </p>
                    <p>the terms of this TOS.</p>
                    <br>
                    <p><strong>I. DESCRIPTION OF SERVICES</strong></p>
                    <br>
                    <p>Any reference to the “website”, the “web site”, the “site”, “www.songabout.fm” or other similar references, shall include any and </p>
                    <p>all pages, subdomains, affiliated domains, brands, products or other areas of our website, or any other affiliated sites or domains </p>
                    <p>owned or operated by or on behalf of us, plus any of the online content, information and services as made available in or thought the </p>
                    <p>website. The Company offers the website and certain other services and applications or mobile apps (collectively, the &quot;Services&quot;). </p>
                    <p>The Services include without limitation all aspects of the website, including but not limited to all products, software, applications, </p>
                    <p>features, channels and services offered therein. Any reference to “content” shall include all content in all forms or mediums, such </p>
                    <p>as (without limitation) text, software, scripts, graphics, photos, sounds, music, videos, audiovisual combinations, interactive features </p>
                    <p>and other materials you may view on, access through, or contribute to the Service. You must be 18 years or older to use this </p>
                    <p>website and/or the other Services. All information and services are exchanged electronically, via the internet. You are responsible </p>
                    <p>for maintaining your own access to the internet. You consent to receiving communications electronically. Company is a privately </p>
                    <p>owned and operated service and does not represent or speak for any governmental office or authority.</p>
                    <br>
                    <p><strong>II. PASSWORDS AND ACCESS</strong></p>
                    <br>
                    <p>In order to access some features of the Service, you may have to register or create an account. You may never use another's </p>
                    <p>account without permission. When creating your account, you must provide accurate and complete information. Registration or </p>
                    <p>subscription to the Service and payment of any applicable fee, authorizes a single individual to use the Service unless otherwise </p>
                    <p>expressly stated. You are solely responsible for the activity that occurs on your account, and you must keep your account password </p>
                    <p>secure. You must notify Company immediately of any breach of security or unauthorized use of your account. Although Company </p>
                    <p>will not be liable for your losses caused by any unauthorized use of your account, you may be liable for the losses of Company or </p>
                    <p>others due to such unauthorized use.</p>
                    <br>
                    <p>You may not grant, resell or sublicense access to the Services or the Service, or any of the rights granted to you herein, to any </p>
                    <p>third party. You agree not to reproduce, duplicate, copy, sell, resell or exploit any part of the Services or the Service. You may not </p>
                    <p>decompile, disassemble, reverse engineer or otherwise attempt to obtain or access the source code from which any component </p>
                    <p>of the Services or the Service is compiled or interpreted, and nothing in this Agreement may be construed to grant any right to </p>
                    <p>obtain or use such source code. You agree not to copy, duplicate or imitate, in whole or in part, any concept, idea, business model, </p>
                    <p>business process, product, service or other intellectual property or other ideas or content embodied in the Services or learned by </p>
                    <p>you from your use of or access to the Services. You agree not to use the Services or the Service to violate any local, state, national </p>
                    <p>or international law or to impersonate any person or entity, or otherwise misrepresent your identity or your affiliation with a person or </p>
                    <br>
                    <p>You shall not download any content unless you see a “download” or similar link displayed by Company on the Service for that </p>
                    <p>content. You shall not copy, reproduce, distribute, transmit, broadcast, display, sell, license, or otherwise exploit any content for any </p>
                    <p>other purposes without the prior written consent of Company or the respective licensors of the content. Company and its licensors </p>
                    <p>reserve all rights not expressly granted in and to the Service and the content.</p>
                    <br>
                    <p>You agree not to circumvent, disable or otherwise interfere with security-related features of the Service or features that prevent or </p>
                    <p>restrict use or copying of any content or enforce limitations on use of the Service or the content therein.</p>
                    <br>
                    <p><strong>III. YOUR OBLIGATIONS</strong></p>
                    <br>
                    <p>You represent and warrant that all information that you provide to us will be true, accurate, complete and current, and that you have </p>
                    <p>the right to provide such information to us in connection with your use of the Service. </p><br>
                    <p>You May Not:</p>
                    <p>1. restrict or inhibit any other user from using and enjoying the Services;</p>
                    <p>2. post or transmit any unlawful, fraudulent, libelous, defamatory, obscene, pornographic, vulgar, sexually-orientated, </p>
                    <p>profane, threatening, abusive, hateful, offensive, false, misleading, derogatory, or otherwise objectionable information </p>
                    <p>of any kind, including without limitation any transmissions constituting or encouraging conduct that would constitute a </p>
                    <p>criminal offense, give rise to civil liability, or otherwise violate any local, state, national or foreign law, including without </p>
                    <p>limitation the U.S. export control laws and regulations;</p>
                    <p>3. post or transmit any advertisements, solicitations, chain letters, pyramid schemes, investment opportunities or schemes </p>
                    <p>or other unsolicited commercial communication (except as otherwise expressly permitted by Company) or engage in </p>
                    <p>spamming or flooding;</p>
                    <p>4. post or transmit any information or software which contains a virus, trojan horse, worm or other harmful component;</p>
                    <p>5. upload, post, publish, reproduce, transmit or distribute in any way any component of the Service itself or derivative works </p>
                    <p>6. resell or otherwise exploit for commercial purposes, directly or indirectly, any portion of the Services, or access to them;</p>
                    <p>7. use email addresses obtained from the Services for solicitation purposes of any kind, directly or indirectly;</p>
                    <p>8. use data mining, robots or other similar data gathering and extraction tools;</p>
                    <p>9. make any derivative works based, in whole or in part, on any portion or all of the Services;</p>
                    <p>10. use webpage frames to enclose any part of the Services;</p>
                    <p>11. use a false email address, impersonate any person or entity, forge e-mail headers or otherwise disguise the origin of any </p>
                    <p>communication or mislead as to the source of the information you provide to the Services;</p>
                    <p>12. portray Company or its affiliates in a negative manner or otherwise portray its services in a false, misleading, derogatory </p>
                    <p>13. use the Services in any manner that could damage, disable, overburden, or impair our servers or interfere with any other </p>
                    <p>party's use and enjoyment of the Services;</p>
                    <p>14. attempt to gain unauthorized access to any services or information to which you have not been granted access through </p>
                    <p>password mining or any other process;</p>
                    <p>15. post or transmit any photograph or likeness of another person without that person's consent, if and to the extent </p>
                    <p>necessary under applicable laws;</p>
                    <p>16. post, publish, transmit, reproduce, distribute or in any way exploit any information, software or other material obtained </p>
                    <p>through the Services for commercial purposes (other than as expressly permitted by the Service and by the provider of </p>
                    <p>such information, software or other material); or</p>
                    <p>17. upload, post, publish, transmit, reproduce, or distribute in any way, information, software or other material obtained </p>
                    <p>through the Services which is protected by copyright, or other proprietary right, or derivative works with respect thereto, </p>
                    <p>without obtaining permission of the copyright owner or rightholder, or which otherwise violates or infringes the rights of </p>
                    <p>others, including without limitation, patent, trademark, trade secret, copyright, publicity, or other proprietary rights.</p>
                    <br>
                    <p>Company has no obligation to monitor the Services. However, you acknowledge and agree that Company has the right to monitor </p>
                    <p>the Services electronically from time to time, and to disclose any information as necessary or appropriate to satisfy any law, </p>
                    <p>regulation or other governmental request, to operate the Services properly, or to protect itself or its customers. Company reserves </p>
                    <p>the right to refuse to post or to remove any information or materials, in whole or in part, that, in its sole discretion, are unacceptable, </p>
                    <p>undesirable, inappropriate or in violation of this Agreement.</p>
                    <br>
                    <p>Usage of Lyrics is limited to your personal, noncommercial use in accordance with the terms of this Agreement. You may not </p>
                    <p>reproduce (other than as authorized for your own personal usage), publish, transmit, distribute, publicly display, rent or lend, modify, </p>
                    <p>create derivative works from, sell or participate in the sale of or exploit in any way, in whole or in part, directly or indirectly, any of the </p>
                    <p>Services, including without limitation any Lyrics so provided. You agree that you are not granted any so-called &quot;karaoke&quot; or &quot;sing-
                      along&quot; rights to Lyrics </p><p>and you shall not seek to or remove any vocal track from a sound recording that shall be associated with a </p>
                    <p>Lyric provided to you. You agree not to assign, transfer or transmit any Lyrics to any third party. You agree that you shall not seek </p>
                    <p>to or do anything that will defeat, evade or circumvent any efforts that may be made to protect the Lyrics from any unauthorized </p>
                    <br>
                    <p>While this Section highlights some of your key obligations, headers and section titles are for convenience only, and you are bound </p>
                    <p>by all the terms of this Agreement.</p>
                    <br>
                    <p><strong>IV. PUBLIC POSTINGS AND LICENSED MATERIALS</strong></p>
                    <br>
                    <p>We will use all reasonable efforts to protect the confidentiality of certain personally identifiable information you submit to us </p>
                    <p>(e.g., your address and credit card information submitted by you initially for the purpose subscribing to the Service) (“Personally </p>
                    <p>Identifiable Information”), in accordance with the Privacy Policy posted on our website. </p>
                    <br>
                    <p>Certain material you may post on our Services is or may be available to the public, including without limitation any public profile </p>
                    <p>data, feedback, questions, comments, suggestions, uploads, blog entries, ratings, reviews, images, videos, poll answers, etc., in any </p>
                    <p>form or media, that you post via the Service or otherwise (collectively, &quot;Public Postings&quot;). These Public Postings will be treated as </p>
                    <p>non-confidential and nonproprietary. You are responsible for any Public Postings and the consequences of sharing or publishing </p>
                    <p>such content with others or the general public. This includes, for example, any personal information, such as your home address, </p>
                    <p>the home address of others, or your current location. WE ARE NOT RESPONSIBLE FOR THE CONSEQUENCES OF PUBLICLY </p>
                    <p>SHARING OR POSTING ANY PERSONAL OR OTHER INFORMATION ON THE SERVICES.</p>
                    <br>
                    <p>Other content or communications you transmit to us, including without limitation any feedback, data, questions, comments, </p>
                    <p>suggestions, in any form or media, that you submit to us via e-mail, the Services or otherwise (to the extent excluding any </p>
                    <p>Personally Identifiable Information, collectively, &quot;Submissions&quot;), will be treated as non-confidential and nonproprietary. </p>
                    <br>
                    <p>By providing any Public Posting or Submission, you (i) grant to Company a royalty-free, non-exclusive, perpetual, irrevocable, sub-</p><p>
                      licensable right to use, reproduce, modify, adapt, publish, translate, create derivative works (including products) from, distribute, and </p>
                    <p>display such content throughout the world in all media and you license to us all patent, trademark, trade secret, copyright or other </p>
                    <p>proprietary rights in and to such content for publication on the Service pursuant to this Agreement; (ii) agree that we shall be free </p>
                    <p>to use any ideas, concepts or techniques embodied therein for any purpose whatsoever, including, but not limited to, developing </p>
                    <p>and marketing products or services incorporating such ideas, concepts, or techniques, without attribution, without any liability or </p>
                    <p>obligation to you; (iii) grant to Company the right to use the name that you submit in connection with such content. In addition, you </p>
                    <p>hereby waive all moral rights you may have in any Public Posting or Submissions.</p>
                    <br>
                    <p>You shall be solely responsible for your own content and any Pubic Postings and Submissions. You affirm, represent, and warrant </p>
                    <p>that you own or have the necessary licenses, rights, consents, and permissions to publish content you post or submit. You further </p>
                    <p>agree that content you submit via Public Postings or Submissions will not contain third party copyrighted material, or material that is </p>
                    <p>subject to other third party proprietary rights, unless you have permission from the rightful owner of the material or you are otherwise </p>
                    <p>legally entitled to post the material and to grant us all of the license rights granted herein. You further agree that you will not submit </p>
                    <p>to the Service any content or other material that is contrary to our Community Guidelines, which may be updated from time to time, </p>
                    <p>or contrary to applicable local, national, and international laws and regulations.</p>
                    <br>
                    <p>We do not endorse any content submitted to the Service by any user or other licensor, or any opinion, recommendation, or advice </p>
                    <p>expressed therein, and we expressly disclaim any and all liability in connection with content. We do not permit copyright infringing </p>
                    <p>activities and infringement of intellectual property rights on the Service, and we will remove all content if properly notified that such </p>
                    <p>content infringes on another's intellectual property rights. We reserve the right to remove content without prior notice. We reserve </p>
                    <p>the right to decide whether your content violates this Agreement for reasons other than copyright infringement, such as, but not </p>
                    <p>limited to, pornography, obscenity, or excessive length. We may at any time, without prior notice and in our sole discretion, remove </p>
                    <p>such content and/or terminate a user's account for submitting such material in violation of this Agreement.</p>
                    <br>
                    <p><strong>V.  FEES AND PAYMENTS</strong></p>
                    <br>
                    <p>If and to the extent any portion of the Service may require a fee payment or incremental payment or subscription, you agree to pay </p>
                    <p>Company any applicable fee posted for the Service. By completing and submitting any credit card or other payment authorization </p>
                    <p>through the Services, you are authorizing Company to charge the fees to the account you identify. You must keep all billing </p>
                    <p>information, including payment method, up to date. You agree to pay us for all charges incurred under your account, including all </p>
                    <p>applicable taxes, fees, and surcharges. You authorize and direct us to charge your designated payment method for these charges </p>
                    <p>or, if your designated payment method fails, to charge any other payment method you have on file with us. Further, you authorize </p>
                    <p>and direct us to retain information about the payment method(s) associated with your account. If we do not receive payment from </p>
                    <p>your designated payment method or any other payment method on file, you agree to pay all amounts due upon demand by us. You </p>
                    <p>will be responsible for accrued but unpaid charges, even if your account is canceled by you or terminated by us. During any free </p>
                    <p>trial or other promotion, if any, you will still be responsible for any purchases and surcharges incurred using your account. </p>
                    <br>
                    <p>After 30 days from the date of any unpaid charges, your fee-based Service will be deemed delinquent and we may terminate or </p>
                    <p>suspend your account and Service for nonpayment. We reserve the right to assess an additional 1.5 percent late charge (or the </p>
                    <p>highest amount allowed by law, whichever is lower) per month if your payment is more than 30 days past due and to use any lawful </p>
                    <p>means to collect any unpaid charges. You are liable for any fees, including attorney and collection fees, incurred by us in our efforts </p>
                    <p>to collect any remaining balances from you.</p>
                    <br>
                    <p>You are responsible for all charges incurred under your account, including applicable taxes, fees, surcharges, and purchases made </p>
                    <p>by you or anyone you allow to use your account (including your children, family, friends, or any other person with implied, actual, or </p>
                    <p>apparent authority) or anyone who gains access to your account as a result of your failure to safeguard your username, password, </p>
                    <p>or other authentication credentials or information.</p>
                    <br>
                    <p><strong>VI. WARRANTIES AND LIMITATIONS OF WARRANTIES.</strong></p>
                    <br>
                    <p>If you are not completely satisfied with the Service, your sole remedy is that you may cancel at any time on 30 days advanced </p>
                    <p>notice. If you cancel properly, and cease to use the Service, you will not be charged any additional amounts after the effective </p>
                    <p>date of such termination, but you will be responsible for any and all charges and activity accrued prior to such date. Company </p>
                    <p>undertakes commercially reasonable efforts to ensure that the information it provides is current and accurate. However, </p>
                    <p>Company does not warrant the accuracy of information. Company also undertakes commercially reasonable efforts to protect the </p>
                    <p>confidentiality of any confidential information you provide, in accordance with the privacy policy stated on the Services. However, </p>
                    <p>Company does not guaranty the confidentiality of such information against unauthorized third party access or system failure.</p>
                    <br>
                    <p>THE SERVICE, THE WEBSITE, AND ALL INFORMATION, CONTENT, AND MATERIALS RELATED TO THE FOREGOING, ARE </p>
                    <p>PROVIDED &quot;AS IS.&quot; EXCEPT AS EXPRESSLY STATED IN THIS AGREEMENT, WE DISCLAIM ALL WARRANTIES, EXPRESS </p>
                    <p>OR IMPLIED, INCLUDING, BUT NOT LIMITED TO, ANY WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR </p>
                    <p>PURPOSE, TITLE, NON-INFRINGEMENT, NON-INTERFERENCE, SYSTEM INTEGRATION AND ACCURACY OF DATA. WE </p>
                    <p>DO NOT WARRANT THAT USE OF THE SERVICE WILL BE UNINTERRUPTED, ERROR-FREE OR VIRUS FREE. ALTHOUGH </p>
                    <p>INFORMATION THAT YOU SUBMIT MAY BE PASSWORD PROTECTED, WE DO NOT GUARANTEE THE SECURITY OF ANY </p>
                    <p>INFORMATION TRANSMITTED TO OR FROM THE SERVICE AND YOU AGREE TO ASSUME THE SECURITY RISK FOR ANY </p>
                    <p>INFORMATION YOU PROVIDE THROUGH THE SERVICE.</p>
                    <br>
                    <p><strong>VII. LIMITATIONS OF LIABILITY.</strong></p>
                    <br>
                    <p>IN NO EVENT SHALL WE OR OUR AFFILIATES BE LIABLE FOR ANY INDIRECT, INCIDENTAL, CONSEQUENTIAL OR </p>
                    <p>SPECIAL DAMAGES, OR FOR LOSS OF PROFITS OR DAMAGES ARISING DUE TO BUSINESS INTERRUPTION OR FROM </p>
                    <p>LOSS OR INACCURACY OF INFORMATION, TO THE EXTENT ANY OF THE FOREGOING ARISES IN CONNECTION WITH </p>
                    <p>THIS AGREEMENT OR YOUR USE OR INABILITY TO USE THE SERVICE, WHETHER OR NOT SUCH DAMAGES WERE </p>
                    <p>FORESEEABLE AND EVEN IF WE WERE ADVISED THAT SUCH DAMAGES WERE LIKELY OR POSSIBLE. IN NO EVENT </p>
                    <p>WILL THE AGGREGATE LIABILITY OF US TO YOU FOR ANY AND ALL CLAIMS ARISING IN CONNECTION WITH THIS </p>
                    <p>AGREEMENT OR THE SERVICE, EXCEED THE TOTAL FEES PAID TO US BY YOU DURING THE SIX-MONTH PERIOD </p>
                    <p>PRECEDING THE DATE OF ANY CLAIM. YOU ACKNOWLEDGE THAT THIS LIMITATION OF LIABILITY IS AN ESSENTIAL </p>
                    <p>TERM BETWEEN YOU AND US RELATING TO THE PROVISION OF THE SERVICE TO YOU AND WE WOULD NOT PROVIDE </p>
                    <p>THE SERVICE TO YOU WITHOUT THIS LIMITATION.</p>
                    <br>
                    <p>YOU AGREE TO INDEMNIFY AND HOLD HARMLESS US AND OUR AFFILIATES AND EACH OF THEIR RESPECTIVE </p>
                    <p>OFFICERS, DIRECTORS, MEMBERS, AGENTS, AND EMPLOYEES FROM AND AGAINST ALL LOSSES, EXPENSES, </p>
                    <p>DAMAGES, COSTS AND LIABILITIES, INCLUDING REASONABLE ATTORNEYS' FEES, INCURRED BY US AND RESULTING </p>
                    <p>FROM (1) ANY VIOLATION BY YOU OF THIS AGREEMENT; (2) ANY ACTIVITY RELATED TO YOUR ACCOUNT BY YOU OR </p>
                    <p>ANY OTHER PERSON ACCESSING THE SERVICE WITH YOUR PASSWORD; (3) YOUR USE OF AND ACCESS TO THE </p>
                    <p>SERVICES; (4) YOUR VIOLATION OF ANY THRID PARTY RIGHT, INCLUDING WITHOUT LIMITATION ANY COPYRIGHT, </p>
                    <p>PROPERTY OR PRIVACY RIGHT; AND/OR (5) ANY CLAIM THAT YOUR CONTENT CAUSED DAMAGED TO A THIRD PARTY. </p>
                    <p>THIS DEFENSE AND INDEMNIFICATION OBLIGATION WILL SURVIVE THIS AGREEMENT AND YOUR USE OF THE SERVICE. </p>
                    <br>
                    <p><strong>VIII. DURATION OF TERMS</strong></p>
                    <br>
                    <p>Once in effect, this Agreement will continue in operation until terminated by either you or us. However, even after termination, the </p>
                    <p>provisions of sections IV through XV of this Agreement will remain in effect. You may terminate this Agreement at any time and </p>
                    <p>for any reason by providing notice to Company in the manner specified in this Agreement or by choosing to cancel your access </p>
                    <p>to the Service using the tools provided for that purpose within the Service. We may terminate this Agreement without notice or, </p>
                    <p>at our option, temporarily suspend your access to the Services, in the event that you breach this Agreement. Notwithstanding </p>
                    <p>the foregoing, Company also reserves the right to terminate this Agreement at any time and for any reason by providing notice </p>
                    <p>to you either through email or other reasonable means. After termination of this Agreement for any reason, you understand and </p>
                    <p>acknowledge that Company will have no further obligation to provide the Service or access thereto. Upon termination, all licenses </p>
                    <p>and other rights granted to you by this Agreement, if any, will immediately cease. </p>
                    <br>
                    <p><strong>IX. MODIFICATION OF TERMS</strong></p>
                    <br>
                    <p>Company may change the terms of this Agreement from time to time. You will be notified of any such changes via e-mail (if you </p>
                    <p>have provided a valid email address) and/or by posting notice of the changes on the Services. Any such changes will become </p>
                    <p>effective when notice is received or when posted on the Services, whichever first occurs. If you object to any such changes, your </p>
                    <p>sole recourse will be to terminate this Agreement. Continued use of the Service following notice of any such changes will indicate </p>
                    <p>your acknowledgement of such changes and agreement to be bound by such changes. </p>
                    <br>
                    <p><strong>X. MODIFICATIONS TO SERVICES</strong></p>
                    <br>
                    <p>We reserve the right to modify or discontinue the Service at any time with or without notice to you, including without limitation by </p>
                    <p>adding or subtracting features and functionality, reward mechanisms, third party content, etc. Rewards, if any, are arbitrary and </p>
                    <p>may be based on amount of use or other metrics as we determine in our sole discretion. In the event of such modification or </p>
                    <p>discontinuation of the Service, your sole remedy shall be to terminate this Agreement. Continued use of the Service following notice </p>
                    <p>of any such changes will indicate your acknowledgement and acceptance of such changes and satisfaction with the Service as so </p>
                    <br>
                    <p><strong>XI. OWNERSHIP</strong></p>
                    <br>
                    <p>We and/or our vendors and suppliers, as applicable, retain all right, title and interest in and to the Service, the website and all </p>
                    <p>information, content, software and materials provided by or on behalf of us, including but not limited to all text, images, videos, </p>
                    <p>logos, button icons, audio clips, data compilations, and the look and feel of the website and our brands and logos. Except for the </p>
                    <p>use of publicly available forms and information which you obtain from sources other than us, you agree that you will not copy, </p>
                    <p>reproduce, distribute or create derivative works from any information, content, software or materials provided by us, or remove any </p>
                    <p>copyright or other proprietary rights notices contained in any such information, content, software or materials without the copyright </p>
                    <p>Unless otherwise stated, all content in our websites or other Services, is our property or the property of third parties. These contents </p>
                    <p>are protected by copyright as a collective work and/or compilation, pursuant to U.S. copyright laws, international conventions and </p>
                    <p>Your feedback is welcome and encouraged. You agree, however, that (i) by submitting unsolicited ideas to us, you automatically </p>
                    <p>forfeit your right to any intellectual property rights in such ideas; and (ii) unsolicited ideas submitted to us or any of our employees or </p>
                    <p>representatives automatically become our property.</p>
                    <p>The Service is controlled, operated and administered by us from within the United States. Company makes no representation that </p>
                    <p>this site is available for access or use at other locations outside the U.S. However, any access or use from outside the U.S. is still </p>
                    <p>subject to this Agreement. Access to this Service is expressly prohibited from territories where this site or any portion thereof is </p>
                    <p>illegal. You agree not to access or use any information or materials on the Service in violation of U.S. export laws and regulations, or </p>
                    <p>in violation of any laws or regulations in the country from which you are accessing the Service. </p>
                    <br>
                    <p><strong>XIII. THIRD PARTY CONTENT</strong></p>
                    <br>
                    <p>Certain content on the Services may be supplied by third parties. Company does not have editorial control over such content. </p>
                    <p>Any opinions, advice, statements, services, offers, or other information that constitutes part of the content expressed or made </p>
                    <p>available by third parties, including without limitation, suppliers and vendors, or any customer or user of the Service, are those of </p>
                    <p>the respective authors or distributors and not of Company or its affiliates or any of its officers, directors, employees, or agents. In </p>
                    <p>many instances, the content available on the Service represents the opinions and judgments of the respective third parties, whether </p>
                    <p>or not under contract with Company. Company neither endorses nor is responsible for the accuracy or reliability of any opinion, </p>
                    <p>advice, submission, posting, or statement made on the Service. Under no circumstances shall Company, or its affiliates, or any of </p>
                    <p>their respective officers, directors, employees, or agents, be liable for any loss or damage caused by your reliance on any content or </p>
                    <p>other information obtained through the Service. </p>
                    <p>Without limiting the generality of the foregoing, we may elect, in our discretion, to utilize social logins, allowing you to login to the </p>
                    <p>Service via other third party authentication services, such as (without limitation) via your Facebook, Twitter, LinkedIn, Google, or </p>
                    <p>other account credentials. You understand that these are third party services, and this in no way creates and endorsement of, by or </p>
                    <p>from us to them or vice versa, that we are not responsible for their logins, systems or data, and that by using such third party logins, </p>
                    <p>you may be subject to their respective privacy policies and other terms of use. </p>
                    <p>You understand that when using the Service, you will be exposed to content from a variety of sources, and that we are not </p>
                    <p>responsible for the accuracy, usefulness, safety, or intellectual property rights of or relating to such content. You further understand </p>
                    <p>and acknowledge that you may be exposed to content that is inaccurate, offensive, indecent, or objectionable, and you agree to </p>
                    <p>waive, and hereby do waive, any legal or equitable rights or remedies you have or may have against us with respect thereto, and, to </p>
                    <p>the extent permitted by applicable law, agree to indemnify and hold harmless Company, its owners, operators, affiliates, licensors, </p>
                    <p>and licensees to the fullest extent allowed by law regarding all matters related to your use of the Service.</p>
                    <p>As a convenience to you, Company may provide on the Service one or more links to third party web sites or services and/or provide </p>
                    <p>email contacts respecting third parties. Company makes no endorsement of such third parties, nor any representation or warranty </p>
                    <p>regarding anything that takes place between you and any such third parties, including, without limitation, visits to third party web </p>
                    <p>sites, services, email correspondence with third parties, and business or other transactions with third parties found through the </p>
                    <p>Services. Please understand that such third parties are independent from and not controlled by Company, even if, for example, a </p>
                    <p>Company link or logo appears on a website linked from this website or our other Services. It is up to you to read those third party </p>
                    <p>sites’ applicable terms of use, privacy, and other applicable policies. </p>
                    <br>
                    <p><strong>XIV. Digital Millennium Copyright Act</strong></p>
                    <br>
                    <p>A. If you are a copyright owner or an agent thereof and believe that any content infringes upon your copyrights, you may submit </p>
                    <p>a notification pursuant to the Digital Millennium Copyright Act (&quot;DMCA&quot;) by providing our Copyright Agent with the following </p>
                    <p>information in writing (see 17 U.S.C 512(c)(3) for further detail):</p>
                    <br>
                    <p>• A physical or electronic signature of a person authorized to act on behalf of the owner of an exclusive right that is </p>
                    <p>• Identification of the copyrighted work claimed to have been infringed, or, if multiple copyrighted works at a single online </p>
                    <p>site are covered by a single notification, a representative list of such works at that site;</p>
                    <p>• Identification of the material that is claimed to be infringing or to be the subject of infringing activity and that is to be </p>
                    <p>removed or access to which is to be disabled and information reasonably sufficient to permit the service provider to locate </p>
                    <p>• Information reasonably sufficient to permit the service provider to contact you, such as an address, telephone number, </p>
                    <p>and, if available, an electronic mail;</p>
                    <p>• A statement that you have a good faith belief that use of the material in the manner complained of is not authorized by the </p>
                    <p>copyright owner, its agent, or the law; and</p>
                    <p>• A statement that the information in the notification is accurate, and under penalty of perjury, that you are authorized to act </p>
                    <p>on behalf of the owner of an exclusive right that is allegedly infringed.</p>
                    <br>
                    <p>Company's designated method to receive notifications of claimed infringement is by emailing the Copyright Agent at </p>
                    <p>info@songabout.fm . Other feedback, comments, requests for technical support, and other communications should also be directed </p>
                    <p>to Company customer service through the same email address as mentioned above. You acknowledge that if you fail to comply with </p>
                    <p>all of the requirements of this Section 5(D), your DMCA notice may not be valid.</p>
                    <br>
                    <p>Please note that, by way of example and not as a limitation, any content made available on or through the Service which contains </p>
                    <p>or displays the YouTube logo or which is provided via the YouTube player is hosted on YouTube's servers, and Company thus </p>
                    <p>does not have the ability to permanently remove all or any such content from YouTube's servers. Therefore, if you have a complaint </p>
                    <p>concerning any video content made available on the Service that is provided by YouTube, you should contact YouTube directly </p>
                    <p>in accordance with copyright policies at: http://www.youtube.com/t/terms. If you believe that your work is available on the Website </p>
                    <p>via the YouTube player in a way that constitutes copyright infringement, please: (i) contact YouTube directly in accordance with </p>
                    <p>copyright policies at: http://www.youtube.com/t/terms and (ii) contact Company by sending us a notice in accordance with the </p>
                    <p>B. Counter-Notice. If you believe that your content that was removed (or to which access was disabled) is not infringing, or </p>
                    <p>that you have the authorization from the copyright owner, the copyright owner's agent, or pursuant to the law, to post and use the </p>
                    <p>material in your content, you may send a counter-notice containing the following information to the Copyright Agent:</p><br>
                    <p>• Your physical or electronic signature;</p>
                    <p>• Identification of the content that has been removed or to which access has been disabled and the location at which the </p>
                    <p>content appeared before it was removed or disabled;</p>
                    <p>• A statement that you have a good faith belief that the content was removed or disabled as a result of mistake or a </p>
                    <p>misidentification of the content; and</p>
                    <p>• Your name, address, telephone number, and e-mail address, a statement that you consent to the jurisdiction of the federal </p>
                    <p>court in Los Angeles, and a statement that you will accept service of process from the person who provided notification of </p>
                    <p>the alleged infringement.</p>
                    <br>
                    <p>If a counter-notice is received by the Copyright Agent, Company may send a copy of the counter-notice to the original complaining </p>
                    <p>party informing that person that it may replace the removed content or cease disabling it in 10 business days. Unless the copyright </p>
                    <p>owner files an action seeking a court order against the content provider, member or user, the removed content may be replaced, or </p>
                    <p>access to it restored, in 10 to 14 business days or more after receipt of the counter-notice, at Company's sole discretion.</p>
                    <br>
                    <p><strong>XV. MISCELLANEOUS.</strong></p>
                    <br>
                    <p>You shall comply with all laws, rules and regulations now or hereafter promulgated by any government authority or agency that </p>
                    <p>are applicable to your use of the Service, or the transactions contemplated in this Agreement. You may not assign your rights or </p>
                    <p>obligations hereunder, and any attempt by you to sublicense, assign or transfer any of the rights, duties or obligations hereunder or </p>
                    <p>to exceed the scope of this Agreement is void. In the event that Company is sold to a third party, such a sale will not be deemed a </p>
                    <p>transfer of personal information so long as that third party agrees to assume Company's obligations as to these Terms of Service </p>
                    <p>and any associated Privacy Policy. This Agreement, the Services, and the rights and obligations of the parties with respect to the </p>
                    <p>Services will be subject to and construed in accordance with the laws of the State of California, excluding conflict of law principles. </p>
                    <p>You consent to jurisdiction and venue exclusively in Los Angeles CA. This is the entire agreement between you and Company </p>
                    <p>with regard to the matters described herein and govern your use of the Service, superseding any prior agreements between you </p>
                    <p>and Company with respect thereto. The failure of Company to exercise or enforce any right or provision of this Agreement shall </p>
                    <p>not constitute a waiver of such right or provision. If any provision of this Agreement is found by a court of competent jurisdiction to </p>
                    <p>be invalid, the parties nevertheless agree that the court should endeavor to give effect to the parties' intentions as reflected in the </p>
                    <p>provision, and the other provisions hereof shall remain in full force and effect. You agree that regardless of any statute or law to </p>
                    <p>the contrary, any claim or cause of action arising out of this Agreement or related to use of the Service must be filed within three (3) </p>
                    <p>months after such claim or cause of action arose or be forever barred. </p>
                    <p><strong>Last Updated: March 18, 2014</strong></p>
               	</div>
            </div>
            <span class="clear"></span>
		</div>
    </div>
	<span class="clear"></span>
<? 	include '/home/songabou/www/includes/footer.php'; ?>
