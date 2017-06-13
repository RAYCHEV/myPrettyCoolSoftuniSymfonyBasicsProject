<?php

namespace SoftuniBlogBundle\Command;

use SoftuniBlogBundle\Entity\Author;
use SoftuniBlogBundle\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CreatePostCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('app:create-post')
            ->setDescription('this command creates posts by given title')
            ->setHelp('By Givern args and options u can create psot ant author')
            ->addArgument('title', InputArgument::REQUIRED, 'this is title')
            ->addArgument('description', InputArgument::REQUIRED, 'This post description')
            ->addOption('author-firstName','name', InputOption::VALUE_REQUIRED, 'This is authors first name')
            ->addOption('author-lastname', 'family', InputOption::VALUE_REQUIRED, 'thi is authors lastname');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getContainer();
        $em = $container->get('doctrine') -> getManager();
        $logger = $container->get('logger');

        $postTitle = $input->getArgument('title');
        $postDescription = $input->getArgument('description');

        $post = new Post();
        $post->setTitle($postTitle);
        $post->setDescription($postDescription);
        $post->setCreatedAt(new \DateTime());
        $post->setUpdatedAt(new \DateTime());
        $em->persist($post);
        $em->flush();

        $logger->info(sprintf('post with ID: '.$post->getTitle().' created'));
        if ($input->getOption('author-firstName') && $input->getOption('author-lastname'))
        {
            $firsName = $input->getOption('author-firstName');
            $lastName = $input->getOption('author-lastname');

//            $output->writeln($firsName);
//            $output->writeln($lastName);

            $logger->info("starting create author");
            $author = new Author();
            $author->setFirstName($firsName);
            $author->setLastName($lastName);
            $post->setAuthor($author);
            $em->persist($author);
        }

        $em->flush();
    }
}