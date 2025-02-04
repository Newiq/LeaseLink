@foreach($favorites as $property)
    <x-property-card 
        :id="$property['id']"
        :title="$property['title']"
        :price="$property['price']"
        :beds="$property['beds'] ?? 2"
        :baths="$property['baths'] ?? 2"
        :sqft="$property['sqft'] ?? 1000"
        :image-url="$property['image_url']"
        :is-favorite="true"
    />
@endforeach 