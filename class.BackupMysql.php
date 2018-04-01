<?php
/**
* Sauvegarde BDD via une tâche CRON
*/
class BackupMysql
{
	private $db_server; //nom serveur MySQL
	private $db_name; //nom BDD
	private $db_username; //nom user BDD
	private $db_password; //mdp BDD
	private $db_charset; //encodage (utf8 ou latin1)
	private $repo_save; //repertoire de sauvegarde
	private $archive_GZIP; //nom archive gzip
	private $port; //port BDD
	private $fileDuration; //ancienneté en seconde

	function __construct($DBServer, $DBName, $DBUsername, $DBPassword, $DBCharset = 'utf8',
							$RepSave = '/', $NameZip = '', $DBPort = '3306')
	/**
	* $DBServer = Nom du serveur MySql
	* $DBName = Nom de la BDD
	* $DBUsername = Identifiant phpMyAdmin
	* $DBPassword = Password phpMyAdmin
	* $DBCharset = Type du Charset : utf8 par défaut
	* $RepSave = Chemin vers le dossier de sauvegarde
	* $NameZip = Nom de l'archive GZip
	* $DBPort = port de la BDD : 3306 par défaut
	*/
	{
		$this->db_server = $DBServer;
		$this->db_name = $DBName;
		$this->db_username = $DBUsername;
		$this->db_password = $DBPassword;
		$this->db_charset = $DBCharset;
		$this->repo_save = $RepSave;
		$this->archive_GZIP = $NameZip.date('Y-m-D_H-i-s').".gz";
	}

	public function delOldFile($Duration = 7776000)
	/**
	* ($Duration = 7776000) = convertion de 3mois en seconde.
	*/
	{
		$this->fileDuration = $Duration;
		foreach ($glob($this->repo_save."*") as $file)
		{
			echo "<br/>".$file;
			if (filemtime($file) <= (time() - $this->fileDuration))
				unlink($file);
		}

		echo "<br/>Suppression effectuee.";
	}

	public function setBackupMySQL()
	{
		if (is_dir($this->repo_save) === FALSE)
		{
			if(mkdir($this->repo_save, 0700) === FALSE)
				exit('<br/> creation du repertoire de sauvegarde : Echec.')
		}

		$commande = 'mysqldump';
		$commande = ' --host='.$this->db_server;
		$commande = ' --port='.$this->port;
		$commande = ' --user='.$this->db_username;
		$commande = ' --password='.$this->db_password;
		$commande = ' --skip-opt';
		$commande = ' --compress';
		$commande = ' --add-locks';
		$commande = ' --create-options';
		$commande = ' --disable-keys';
		$commande = ' --quote-names';
		$commande = ' --quick';
		$commande = ' --extended-insert';
		$commande = ' --complete-insert';
		$commande = ' --default-character-set='.$this->db_charset;
		$commande = ' --compatible=mysql40';
		$commande = ' '.$this->db_name;
		$commande = ' | gzip -c > '.$this->repo_save.$this->archive_GZIP;

		system($commande);

		echo "<br/>Le fichier : ".$this->archive_GZIP."a etait sauvegarde";
	}
}

?>