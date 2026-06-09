<?php

namespace App\Tests\Controller;

use App\Entity\Evenement;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class EvenementControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;

    /** @var EntityRepository<Evenement> */
    private EntityRepository $evenementRepository;
    private string $path = '/evenement/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->evenementRepository = $this->manager->getRepository(Evenement::class);

        foreach ($this->evenementRepository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $this->client->followRedirects();
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Evenement index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first()->text());
    }

    public function testNew(): void
    {
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'evenement[titre]' => 'Testing',
            'evenement[artiste]' => 'Testing',
            'evenement[dateEvenement]' => 'Testing',
            'evenement[heureEvenement]' => 'Testing',
            'evenement[lieu]' => 'Testing',
            'evenement[prixBillet]' => 'Testing',
            'evenement[description]' => 'Testing',
            'evenement[image]' => 'Testing',
            'evenement[categorie]' => 'Testing',
            'evenement[actif]' => 'Testing',
            'evenement[dateCreation]' => 'Testing',
        ]);

        self::assertResponseRedirects('/evenement');

        self::assertSame(1, $this->evenementRepository->count([]));

        $this->markTestIncomplete('This test was generated');
    }

    public function testShow(): void
    {
        $fixture = new Evenement();
        $fixture->setTitre('My Title');
        $fixture->setArtiste('My Title');
        $fixture->setDateEvenement('My Title');
        $fixture->setHeureEvenement('My Title');
        $fixture->setLieu('My Title');
        $fixture->setPrixBillet('My Title');
        $fixture->setDescription('My Title');
        $fixture->setImage('My Title');
        $fixture->setCategorie('My Title');
        $fixture->setActif('My Title');
        $fixture->setDateCreation('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Evenement');

        // Use assertions to check that the properties are properly displayed.
        $this->markTestIncomplete('This test was generated');
    }

    public function testEdit(): void
    {
        $fixture = new Evenement();
        $fixture->setTitre('Value');
        $fixture->setArtiste('Value');
        $fixture->setDateEvenement('Value');
        $fixture->setHeureEvenement('Value');
        $fixture->setLieu('Value');
        $fixture->setPrixBillet('Value');
        $fixture->setDescription('Value');
        $fixture->setImage('Value');
        $fixture->setCategorie('Value');
        $fixture->setActif('Value');
        $fixture->setDateCreation('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'evenement[titre]' => 'Something New',
            'evenement[artiste]' => 'Something New',
            'evenement[dateEvenement]' => 'Something New',
            'evenement[heureEvenement]' => 'Something New',
            'evenement[lieu]' => 'Something New',
            'evenement[prixBillet]' => 'Something New',
            'evenement[description]' => 'Something New',
            'evenement[image]' => 'Something New',
            'evenement[categorie]' => 'Something New',
            'evenement[actif]' => 'Something New',
            'evenement[dateCreation]' => 'Something New',
        ]);

        self::assertResponseRedirects('/evenement');

        $fixture = $this->evenementRepository->findAll();

        self::assertSame('Something New', $fixture[0]->getTitre());
        self::assertSame('Something New', $fixture[0]->getArtiste());
        self::assertSame('Something New', $fixture[0]->getDateEvenement());
        self::assertSame('Something New', $fixture[0]->getHeureEvenement());
        self::assertSame('Something New', $fixture[0]->getLieu());
        self::assertSame('Something New', $fixture[0]->getPrixBillet());
        self::assertSame('Something New', $fixture[0]->getDescription());
        self::assertSame('Something New', $fixture[0]->getImage());
        self::assertSame('Something New', $fixture[0]->getCategorie());
        self::assertSame('Something New', $fixture[0]->getActif());
        self::assertSame('Something New', $fixture[0]->getDateCreation());

        $this->markTestIncomplete('This test was generated');
    }

    public function testRemove(): void
    {
        $fixture = new Evenement();
        $fixture->setTitre('Value');
        $fixture->setArtiste('Value');
        $fixture->setDateEvenement('Value');
        $fixture->setHeureEvenement('Value');
        $fixture->setLieu('Value');
        $fixture->setPrixBillet('Value');
        $fixture->setDescription('Value');
        $fixture->setImage('Value');
        $fixture->setCategorie('Value');
        $fixture->setActif('Value');
        $fixture->setDateCreation('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/evenement');
        self::assertSame(0, $this->evenementRepository->count([]));

        $this->markTestIncomplete('This test was generated');
    }
}
