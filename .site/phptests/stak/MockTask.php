<?php
namespace stak;
require_once $_SERVER["DOCUMENT_ROOT"] . "/.site/php/stak/Autoload.php";
use common\base\Response;

/**
 * Mock implementation of Task that serves as a simple container. Also used to test the Task
 * abstract class code since this class provides no new logic.
 * @package stak
 */
class MockTask extends AbstractTask {

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
	protected function updatePrimaryTag(AbstractTag $primaryTag = null, Response &$response = null) {
		return true; }
	protected function updateTags(array $tags, Response &$response = null) {
		return true; }
	protected function updateAddTag(AbstractTag $tag, Response &$response = null) {
		return true; }
	protected function updateRemoveTag(AbstractTag $tag, Response &$response = null) {
		return true; }
	protected function updateParent(AbstractTask $task = null, Response &$response = null) {
		return true; }
	protected function updateChildren(array $children, Response &$response = null) {
		return true; }
	protected function updateAddChild(AbstractTask $child, Response &$response = null) {
		return true; }
	protected function updateRemoveChild(AbstractTask $child, Response &$response = null) {
		return true; }
}