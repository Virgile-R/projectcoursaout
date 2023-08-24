<?php
 
namespace App\Tests\Controller;

use App\Repository\UserRepository; 
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
 
class LoginControllerTest extends WebTestCase
{
    private $client;
 
    protected function setUp():void
    {
        parent::setUp();
 
        $this->client = static::createClient(); 
    }
    public function testLoginPageIsRender()
    {
        $crawler = $this->client->request('GET', '/login');
        $this->assertResponseIsSuccessful();
        $this->assertPageTitleSame('Login');
    }
    public function testSuccessfulLogin()
    {
      $this->client->followRedirects();
      $this->client->request('GET', '/login');
      $crawler = $this->client->submitForm('login', [
        '_username' => 'test0@test.com',
        '_password' => 'Abcde123!'
      ]);
       $this->assertResponseIsSuccessful();
       $this->assertSelectorTextContains('h1', 'Vous êtes connecté !');
    }
 
    public function testWrongLogin()
    {
      $this->client->followRedirects();
      $this->client->request('GET', '/login');
      $crawler = $this->client->submitForm('login', [
        '_username' => 'wrong_user@wrong.com',
        '_password' => 'wrong_password'
    ]);
      $this->assertResponseIsSuccessful();
      $this->assertSelectorTextContains('.errors', 'Invalid credentials.');
    }
 
}