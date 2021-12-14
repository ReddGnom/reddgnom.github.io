<?xml version="1.0" encoding="ISO-8859-1"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

<xsl:template match="/">
	<html>
		<body>
			<h2>System Administration</h2>
			<h2><a href="emailrenewalsdue.php">Home</a></h2>
			
			<table border="1">
				<tr bgcolor="#9acd32">
					<th>Username</th>
					<th>Password</th>
				</tr>
			<xsl:for-each select="systemadmin/account">
				<tr>
					<td><xsl:value-of select="username"/></td>
					<td><xsl:value-of select="password"/></td>
				</tr>
			</xsl:for-each>
			</table>
		</body>
	</html>
</xsl:template>
</xsl:stylesheet>