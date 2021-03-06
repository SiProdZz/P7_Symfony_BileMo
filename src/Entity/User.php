<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Hateoas\Configuration\Annotation as Hateoas;
use JMS\Serializer\Annotation as Serializer;
use OpenApi\Annotations as OA;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
 * @UniqueEntity(
 *  fields={"email"},
 *  message = "L'email que vous indiqué est déjà utilisé !"
 * )
 *
 * @Hateoas\Relation(
 *      "self",
 *      href = @Hateoas\Route(
 *          "user",
 *          parameters = { "id" = "expr(object.getId())" },
 *          absolute = true
 *      ),
 *      exclusion = @Hateoas\Exclusion(
 *          groups={"list_users", "add_user"}
 *      )
 * )
 *
 * @Hateoas\Relation(
 *      "list",
 *      href = @Hateoas\Route(
 *          "users",
 *          absolute = true
 *      ),
 *      exclusion = @Hateoas\Exclusion(
 *          groups={"show_users", "add_user"}
 *      )
 * )
 *
 * @Hateoas\Relation(
 *      "create",
 *      href = @Hateoas\Route(
 *          "add_user",
 *          absolute = true
 *      ),
 *      exclusion = @Hateoas\Exclusion(
 *          groups={"list_users", "show_users"}
 *      )
 * )
 *
 * @Hateoas\Relation(
 *      "remove",
 *      href = @Hateoas\Route(
 *          "delete_user",
 *          parameters = { "id" = "expr(object.getId())" },
 *          absolute = true
 *      ),
 *      exclusion = @Hateoas\Exclusion(
 *          groups={"list_users", "show_users", "add_user"}
 *      )
 * )
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Serializer\Groups({"list_users", "show_users", "add_user"})
     * @OA\Property(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Serializer\Groups({"list_users", "show_users", "add_user"})
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 3,
     *      minMessage = "Le nom doit comporter au moins 3 caractères.",
     *      max = 50,
     *      maxMessage = "Le nom ne doit pas excéder 50 caractères."
     * )
     * @OA\Property(type="string", minLength=3, maxLength=50)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Serializer\Groups({"show_users", "add_user"})
     * @Assert\NotBlank
     * @Assert\Email(
     *     message = "Votre email '{{ value }}' n'est pas un email valid."
     * )
     * @OA\Property(type="string", maxLength=255)
     */
    private $email;

    /**
     * @ORM\Column(type="text")
     * @Serializer\Groups({"show_users", "add_user"})
     * @Assert\NotBlank
     * @Assert\Positive
     * @OA\Property(type="text", maxLength=255)
     */
    private $number;

    /**
     * @ORM\ManyToOne(targetEntity=Customer::class, inversedBy="users")
     * @ORM\JoinColumn(nullable=false)
     */
    private $customer;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function setNumber(string $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(?Customer $customer): self
    {
        $this->customer = $customer;

        return $this;
    }
}
