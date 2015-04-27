<?php
namespace stak\foundation;
require_once $_SERVER["DOCUMENT_ROOT"] . "/.site/php/stak/Autoload.php";
use common\base\Response;

/**
 * Mock implementation of Task that serves as a simple container. Also used to test the Task
 * abstract class code since this class provides no new logic.
 * @package stak\foundation
 */
class MockTask extends Task {

	/**
	 * Simple constructor
	 * @param $title
	 * @param $description
	 * @param $dueDate
	 * @param $completedDate
	 * @param $primaryTag
	 * @param $tags
	 * @param $type
	 */
	public function __construct($title, $description, $dueDate, $completedDate, $primaryTag,
								$tags, $type) {
		$this->title = $title;
		$this->description = $description;
		$this->dueDate = $dueDate;
		$this->completedDate = $completedDate;
		$this->primaryTag = $primaryTag;
		$this->tags = $tags;
		$this->type = $type;
	}

	// Implementor methods. These all return true because we don't have any processing to do with
	// them in mock form.
	protected function updateTitle($title, Response &$response = null) {
		return true; }
	protected function updateDescription($description, Response &$response = null) {
		return true; }
	protected function updateDueDate($dueDate, Response &$response = null) {
		return true; }
	protected function updateCompletedDate($completedDate, Response &$response = null) {
		return true; }
	protected function updatePrimaryTag(Tag $primaryTag = null, Response &$response = null) {
		return true; }
	protected function updateTags(array $tags, Response &$response = null) {
		return true; }
	protected function updateAddTag(Tag $tag, Response &$response = null) {
		return true; }
	protected function updateRemoveTag(Tag $tag, Response &$response = null) {
		return true; }
	protected function updateParent(Task $task = null, Response &$response = null) {
		return true; }
	protected function updateChildren(array $children, Response &$response = null) {
		return true; }
	protected function updateAddChild(Task $child, Response &$response = null) {
		return true; }
	protected function updateRemoveChild(Task $child, Response &$response = null) {
		return true; }
}