<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Poll;

class PollController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index($id)
	{
		$selected_poll = Poll::find($id);
		if ($selected_poll) {
			$selected_poll->views = $selected_poll->views + 1;
			$selected_poll->save();

			$response = [
				"id" => $id,
				"poll_description" => $selected_poll->poll_description,
				"options" => $selected_poll->options
			];

			return $response;
		}

		return "404 Not Found";
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function get_polls()
	{
		$polls = Poll::orderBy('id')->get();

		if ($polls) {
			return $polls;
		}

		return false;
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create(Request $request)
	{
		$new_poll = new Poll;
		$new_poll->poll_description = $request->poll_description;
		$options_available = $request->options;

		$options = [
			["option_id" => 1, "option_description" => ''],
			["option_id" => 2, "option_description" => ''],
			["option_id" => 3, "option_description" => '']
		];

		for ($i = 0; $i < count($options_available); $i++) {
			$options[$i]["option_description"] = $options_available[$i];
		}

		$new_poll->options = $options;
		$new_poll->save();

		$response = [
			"id" => $new_poll->id
		];

		return $response;
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function vote(Request $request, $id)
	{
		$selected_poll = Poll::find($id);
		if ($selected_poll) {

			$selected_choice = $request->choice;

			$options = [
				["option_id" => 1, "qty" => 0],
				["option_id" => 2, "qty" => 0],
				["option_id" => 3, "qty" => 0]
			];

			for ($i = 0; $i < count($options); $i++) {
				$options[$i]["qty"] = $selected_poll->votes[$i]["qty"];
			}

			// zero index based
			$options[$selected_choice-1]["qty"]++;

			$selected_poll->votes = $options;

			$selected_poll->save();

			$response = [
				"option_id" => $selected_choice
			];

			return $response;
		}

		return "404 Not Found";
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function stats($id)
	{
		$selected_poll = Poll::find($id);
		if ($selected_poll) {

			$response = [
				"views" => $selected_poll->views,
				"votes" => $selected_poll->votes
			];

			return $response;
		}

		return "404 Not Found";
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		//
	}
}
