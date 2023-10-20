<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Eloquent\Model;

class CreateForeignKeys extends Migration {

	public function up()
	{
		Schema::table('classes', function(Blueprint $table) {
			$table->foreign('professeur_id')->references('id')->on('professeurs')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('tpns', function(Blueprint $table) {
			$table->foreign('professeur_id')->references('id')->on('professeurs')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('exercices', function(Blueprint $table) {
			$table->foreign('atelier_tpn_id')->references('id')->on('atelier_tpn')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('ateliers', function(Blueprint $table) {
			$table->foreign('site_id')->references('id')->on('sites')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('classe_etudiant', function(Blueprint $table) {
			$table->foreign('etudiant_id')->references('id')->on('etudiants')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('classe_etudiant', function(Blueprint $table) {
			$table->foreign('classe_id')->references('id')->on('classes')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('atelier_tpn', function(Blueprint $table) {
			$table->foreign('tpn_id')->references('id')->on('tpns')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('atelier_tpn', function(Blueprint $table) {
			$table->foreign('atelier_id')->references('id')->on('ateliers')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('questions', function(Blueprint $table) {
			$table->foreign('exercice_id')->references('id')->on('exercices')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('reponses', function(Blueprint $table) {
			$table->foreign('question_id')->references('id')->on('questions')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('statistiques', function(Blueprint $table) {
			$table->foreign('etudiant_id')->references('id')->on('etudiants')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('exercice_user', function(Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('users')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('exercice_user', function(Blueprint $table) {
			$table->foreign('exercice_id')->references('id')->on('exercices')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('classe_tpn', function(Blueprint $table) {
			$table->foreign('classe_id')->references('id')->on('classes')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('classe_tpn', function(Blueprint $table) {
			$table->foreign('tpn_id')->references('id')->on('tpns')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('reponse_user', function(Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('users')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('reponse_user', function(Blueprint $table) {
			$table->foreign('reponse_id')->references('id')->on('reponses')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
	}

	public function down()
	{
		Schema::table('classes', function(Blueprint $table) {
			$table->dropForeign('classes_professeur_id_foreign');
		});
		Schema::table('tpns', function(Blueprint $table) {
			$table->dropForeign('tpns_professeur_id_foreign');
		});
		Schema::table('exercices', function(Blueprint $table) {
			$table->dropForeign('exercices_atelier_tpn_id_foreign');
		});
		Schema::table('ateliers', function(Blueprint $table) {
			$table->dropForeign('ateliers_site_id_foreign');
		});
		Schema::table('classe_etudiant', function(Blueprint $table) {
			$table->dropForeign('classe_etudiant_etudiant_id_foreign');
		});
		Schema::table('classe_etudiant', function(Blueprint $table) {
			$table->dropForeign('classe_etudiant_classe_id_foreign');
		});
		Schema::table('atelier_tpn', function(Blueprint $table) {
			$table->dropForeign('atelier_tpn_tpn_id_foreign');
		});
		Schema::table('atelier_tpn', function(Blueprint $table) {
			$table->dropForeign('atelier_tpn_atelier_id_foreign');
		});
		Schema::table('questions', function(Blueprint $table) {
			$table->dropForeign('questions_exercice_id_foreign');
		});
		Schema::table('reponses', function(Blueprint $table) {
			$table->dropForeign('reponses_question_id_foreign');
		});
		Schema::table('statistiques', function(Blueprint $table) {
			$table->dropForeign('statistiques_etudiant_id_foreign');
		});
		Schema::table('exercice_user', function(Blueprint $table) {
			$table->dropForeign('exercice_user_user_id_foreign');
		});
		Schema::table('exercice_user', function(Blueprint $table) {
			$table->dropForeign('exercice_user_exercice_id_foreign');
		});
		Schema::table('classe_tpn', function(Blueprint $table) {
			$table->dropForeign('classe_tpn_classe_id_foreign');
		});
		Schema::table('classe_tpn', function(Blueprint $table) {
			$table->dropForeign('classe_tpn_tpn_id_foreign');
		});
		Schema::table('reponse_user', function(Blueprint $table) {
			$table->dropForeign('reponse_user_user_id_foreign');
		});
		Schema::table('reponse_user', function(Blueprint $table) {
			$table->dropForeign('reponse_user_reponse_id_foreign');
		});
	}
}