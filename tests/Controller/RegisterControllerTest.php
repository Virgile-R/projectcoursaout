<?php
 
namespace App\Tests\Controller;
 
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
 
class RegisterTest extends WebTestCase
{
    private $client;
    private $entityManager;
    protected function setUp():void
    {
        parent::setUp();
 
        $this->client = static::createClient();
        $this->entityManager = new EntityManagerInterface();
 
        //Créer l'entity manager
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
      $buttonCrawlerNode = $crawler->selectButton('submit');


      $form = $buttonCrawlerNode->form();
      $form['registrationForm[firstName]'] = 'John';
      $form['registrationForm[lastName]'] = 'Doe';
      $form['registrationForm[email]'] = 'john.doe@test.com';
      $form['registrationForm[plainPassword]'] = 'testPassword';
      $form['registrationForm[agreeTerms]']->tick();

      $this->client->submit($form);

      
      $this->assertResponseIsSuccessful();
      $this->assertPageTitleSame('Login');

      $userRepository = static::getContainer()->get(UserRepository::class);
      $testUser = $userRepository->findOneByEmail('john.doe0@test.com');
      $this->assertNotNull($testUser);
    }
 
    protected function tearDown():void{
        parent::tearDown();
        $testUser = $userRepository->findOneByEmail('john.doe0@test.com');
        $this->entityManager->remove($testUser);
        $this->entityManager->flush();
        $this->client = null;
        $this->entityManager = null;
    }
}