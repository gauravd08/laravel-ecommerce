<?php
namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role as Role;
use Validator;
use Socialite;

class SocialAuthController extends \App\Http\Controllers\Controller
{
    /**
     * Redirect to google
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Redirect to FACEBOOK
     */
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * handle the facebook callback here
     */
    public function handleFacebookCallback()
    {
        try 
        {
            $user = Socialite::driver('facebook')->user();
        } 
        catch (\Exception $e) 
        {
            return redirect('/');
        }
        
        //check if user is new
        $this->_checkOrAddUser($user);

        return redirect('/');
    }

    /**
     * handle the google callback here
     */
    public function handleGoogleCallback()
    {
        try 
        {
            $user = Socialite::driver('google')->user();
        } 
        catch (\Exception $e) 
        {
            return redirect('/');
        }
        
        //check if user is new
        $this->_checkOrAddUser($user);

        return redirect('/');
    }

    /**
     * check or add the user in database
     */
    private function _checkOrAddUser($user)
    {
        // check if they're an existing user
        $existingUser = User::where('email', $user->email)->first();
        
        if($existingUser)
        {
            // log them in
            Auth::attempt(['email' => $existingUser->email, 'password' => $existingUser->password]);
        } 
        else 
        {
            // create a new user
            $newUser                  = new User;
            $newUser->name            = $user->name;
            $newUser->email           = $user->email;
            $newUser->password        = Hash::make($this->_generateRandomString());
            $newUser->save();

            //add member role
            $member = Role::where('name', '=', 'member')->first();
            $newUser->attachRole($member);
            
            //log them in
            Auth::attempt(['email' => $newUser->email, 'password' => $newUser->password]);
        }
    }


        /**
     * Random String Generator
     */
    private function _generateRandomString($length = 10) 
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) 
        {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}