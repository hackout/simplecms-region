<?php
namespace SimpleCMS\Region\Packages;

use function is_array;
use Illuminate\Support\Collection;

/**
 * 地理模块
 *
 * @author Dennis Lui <hackout@vip.qq.com>
 */
class RegionModel extends RegionStatic implements \JsonSerializable
{
    /**
     * 下级
     *
     * @var Collection<RegionModel>
     */
    public Collection $children;

    /**
     * 上级
     * @var RegionModel|null
     */
    public ?RegionModel $parent = null;

    public function __construct()
    {
        $this->children = new Collection();
    }

    /**
     * 设置模型
     * @param array $data
     * @param ?RegionStatic $parent
     * @return void
     */
    public function setData(array $data, ?RegionStatic $parent = null): void
    {
        if ($this->deep < 5) {
            $this->initData($data, $parent);
        }
    }

    /**
     * 初始化数据
     * @param array $data
     * @param mixed $parent
     * @return void
     */
    protected function initData(array $data, ?RegionStatic $parent = null)
    {
        $imp = [
            'name' => null,
            'short' => null,
            'code' => null,
            'area' => null,
            'zip' => null,
            'lng' => 0,
            'lat' => 0,
            'children' => []
        ];
        $data = array_merge($imp, $data);
        foreach (array_keys($imp) as $keyName) {
            $this->setValue($keyName, $data[$keyName]);
        }
        $this->parent = $parent;
        if ($this->deep < 4 && is_array($data['children'])) {
            foreach ($data['children'] as $child) {
                $_child = new static();
                $_child->setDeep($this->deep + 1);
                $_child->setData($child, $this->cloneRegion());
                $this->children->push($_child);
            }
        }
    }

    /**
     * 复制
     * @return RegionStatic
     */
    protected function cloneRegion(): RegionStatic
    {
        $self = new static();
        $self->name = $this->name;
        $self->short = $this->short;
        $self->code = $this->code;
        $self->area = $this->area;
        $self->zip = $this->zip;
        $self->lng = $this->lng;
        $self->lat = $this->lat;
        return $self;
    }

    protected function setValue(string $keyName, $value): void
    {
        switch ($keyName) {
            case 'name':
                $this->name = (string) $value;
                break;
            case 'short':
                $this->short = (string) $value;
                break;
            case 'code':
                $this->code = (string) $value;
                break;
            case 'area':
                $this->area = (string) $value;
                break;
            case 'zip':
                $this->zip = (string) $value;
                break;
            case 'lng':
                $this->lng = (float) $value;
                break;
            case 'lat':
                $this->lat = (float) $value;
                break;
        }
    }

    /**
     * toArray
     * @return array<string,null|string|float|int|array<string,null|string|float|int|mixed>>
     */
    public function toArray(): array
    {
        $data = [
            'name' => $this->name ?? null,
            'short' => $this->short ?? null,
            'code' => $this->code ?? 0,
            'area' => $this->area ?? 0,
            'zip' => $this->zip ?? 0,
            'lng' => $this->lng ?? 0,
            'lat' => $this->lat ?? 0,
            'children' => $this->children->toArray()
        ];

        return $data;
    }

    /**
     * 检查名称有效性
     *
     * @param string $name
     * @return bool
     */
    public function checkName(string $name): bool
    {
        return $this->name == $name || $this->short == $name;
    }

    /**
     * 检查代码有效性
     *
     * @param string $code
     * @return bool
     */
    public function checkCode(string $code): bool
    {
        return $this->code == $code;
    }

    /**
     * 检查区号有效性
     *
     * @param string $area
     * @return bool
     */
    public function checkArea(string $area): bool
    {
        return $this->area == $area;
    }

    /**
     * 检查电话号码有效性
     *
     * @param string $number
     * @return bool
     */
    public function checkNumber(string $number): bool
    {
        if (strlen($number) < 10)
            return false;
        $area = substr($number, 0, strlen($this->area));
        return $this->area == $area;
    }

    /**
     * 检查邮编有效性
     *
     * @param string $zip
     * @return bool
     */
    public function checkZip(string $zip): bool
    {
        return substr($this->zip, 0, 5) == substr($zip, 0, 5);
    }

    /**
     * jsonSerialize
     * @return mixed
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }

    /**
     * __toString
     * @return string
     */
    public function __toString(): string
    {
        return json_encode($this->toArray());
    }

    /**
     * 获取上级
     * @return RegionStatic|null
     */
    public function getParent(): ?RegionStatic
    {
        return $this->parent;
    }
}