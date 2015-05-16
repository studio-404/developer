<header>
	<div class="center">
		<div class="navigation">
			<div class="logo">
				<a href="#">
					CMS 1.0.1
				</a>
			</div>

			<nav>
				<ul>
					<li><a href="?action=welcome"><i class="fa fa-home"></i>&nbsp;&nbsp;&nbsp;Home</a></li>
					<li><a href="javascript:;"><i class="fa fa-list"></i>&nbsp;&nbsp;&nbsp;Pages</a>
						<ul>
							<?=$data["managed_pages"]?>
							<li><a href="?action=menuManagment">Page managment</a></li>
						</ul>
					</li>
					<li><a href="javascript:;"><i class="fa fa-cube"></i>&nbsp;&nbsp;&nbsp;Modules</a>
						<ul>
							<li><a href="?action=invoices">Invoices</a></li>
							<li><a href="?action=catalogMoreInfo">Catalog more info</a></li>
							<li><a href="?action=components">Components</a></li>
							<?php
							foreach ($data["components"] as $v) {
							?>	
							 <li><a href="?action=componentModule&id=<?=$v["id"]?>&token=<?=$_SESSION["token"]?>"><i class="fa fa-minus"></i> <?=$v["name"]?></a></li>
							<?php
							}
							?>
						</ul>
					</li>
					<li><a href="javascript:;"><i class="fa fa-users"></i>&nbsp;&nbsp;&nbsp;Users</a>
						<ul>
							<li><a href="?action=userList">User list</a></li>
							<li><a href="?action=userRights">User right groups .??</a></li>
						</ul>
					</li>
					<li><a href="javascript:;"><i class="fa fa-cogs"></i>&nbsp;&nbsp;&nbsp;Settings</a>
						<ul>
							<li><a href="?action=languages">Languages</a></li>
							<li><a href="?action=languageData"><i class="fa fa-minus"></i> Languages data</a></li>
							<li><a href="?action=websiteSettings">Website settings</a></li>
							<li><a href="?action=textConverter">Text converter</a></li>
							<li><a href="?action=log">Log</a></li>
							<li><a href="?action=backup">Backup</a></li>							
						</ul>
					</li>
					<?php 
					if(isset($_SESSION["user404"]) && !empty($_SESSION["user404"])){
					?>
					<li><a href="javascript:;"><i class="fa fa-user-secret"></i>&nbsp;&nbsp;&nbsp;Profile</a>
						<ul>							
							<li><a href="?action=profileSettings">Profile settings</a></li>
							<li><a href="?action=changePassword">Change password</a></li>				
						</ul>
					</li>
					<li><a href="?action=signout"><i class="fa fa-sign-out"></i>&nbsp;&nbsp;&nbsp;Sign out</a></li>	
					<?php
					}
					?>
				</ul>
			</nav>
		</div>
	</div>
</header>