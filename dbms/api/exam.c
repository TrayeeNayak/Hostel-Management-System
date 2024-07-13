#include<stdio.h>
void main()
{
    int a[10],m,n,i;
    printf("Enter number of elements");
    scanf("%d",&n);
    printf("Enter array elements");
    for(i=0;i<n;i++)
    {
        scanf("%d",&a[i]);
    }
    while(i<n)
    {
        i=a[i];
        n=n-a[i];
        /* for(i=0;i<n;i++)
        { */
            if(a[i]==n)
            {
                printf("truee");
            }
            else{
                printf("false");
           /*  } */

        }
    }
}