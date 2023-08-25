<?php
 
namespace App\Tests\Controller;
 
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
 
class RegisterControllerTest extends WebTestCase
{
    private $client;
    private $entityManager;
    protected function setUp():void
    {
        parent::setUp();
 
        $this->client = static::createClient();
        $this->entityManager = static::getContainer()
            ->get('doctrine')
            ->getManager();
 
    }
    public function testRenderRegisterPage()
    {
      $crawler = $this->client->request('GET', '/register');
      $this->assertResponseIsSuccessful();
      $this->assertPageTitleSame('Register');
    }
 
    public function testSuccessfulRegister()
    {
      $this->client->followRedirects();
      $crawler = $this->client->request('GET', '/register');
      $buttonCrawlerNode = $crawler->selectButton('Register');


      $form = $buttonCrawlerNode->form();
      $form['registration_form[firstName]'] = 'John';
      $form['registration_form[lastName]'] = 'Doe';
      $form['registration_form[email]'] = 'john.doe@test.com';
      $form['registration_form[plainPassword]'] = 'testPassword';
      $form['registration_form[agreeTerms]']->tick();

      $this->client->submit($form);

      
      $this->assertResponseIsSuccessful();
      $this->assertPageTitleSame('Login');

      $testUser = $this->entityManager->getRepository(User::class)->findOneByEmail('john.doe@test.com');
      
      $this->assertNotNull($testUser);
    }

    public function testUnsuccessfulRegister()
    { 
      $crawler = $this->client->request('GET', '/register');
      $buttonCrawlerNode = $crawler->selectButton('Register');


      $form = $buttonCrawlerNode->form();
      $form['registration_form[firstName]'] = 'John';
      $form['registration_form[lastName]'] = 'Doe';
      $form['registration_form[email]'] = 'wrongemailformat';
      $form['registration_form[plainPassword]'] = 'testPassword';
      $form['registration_form[agreeTerms]']->tick();

      $this->client->submit($form);
      $this->assertResponseIsSuccessful();
      $this->assertPageTitleSame('Register');
      $this->assertSelectorTextContains('li', 'Please enter a valid email.' );


    }
 
    protected function tearDown():void{
        parent::tearDown();
        $testUser = $this->entityManager->getRepository(User::class)->findOneByEmail('john.doe@test.com');
        if ($testUser) {
          $this->entityManager->remove($testUser);
          $this->entityManager->flush();
        }
        $this->client = null;
        $this->entityManager = null;
    }
}